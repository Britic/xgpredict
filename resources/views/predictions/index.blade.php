@extends('layouts.app')

@section('content')
    <div class="container">

        <h3>Predictions: <small>{{ $round->name }}</small></h3>
        <hr />
        <div class="row">
            <h3>Fixtures</h3>
        </div>

        <?php //dump($predictionsData); ?>

        <div class="row">


            <table class="table fs-20">
                <thead>
                    <tr>
                        <th class="d-none d-lg-table-cell">Date &amp; Time</th>
                        <th class="d-none d-lg-table-cell">Competition</th>
                        <th>Home</th>
                        <th>Away</th>
                    @foreach ($predictionsData['users'] as $user)
                        <th class="th-center">{{ $user->name }}</th>
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                @foreach($predictionsData['fixtures'] as $fixtureId => $fixtureData)
                    <tr class="{{ $fixtureData['hasAction'] ? 'has-action' : '' }}">
                        <td class="d-none d-lg-table-cell">{{ $fixtureData['fixture']->fixture_date->format('l, F j g:ia') }}</td>
                        <td class="d-none d-lg-table-cell">{{ $fixtureData['fixture']->league->abbr }}</td>
                        <td>
                            <img class="icon-small" src="/icons/teams/{{ $fixtureData['fixture']->team_1 }}.ico" />
                            <span class="fixture-team-name home-team-name">{{ $fixtureData['fixture']->team1->name }}</span>
                        </td>
                        <td>
                            <img class="icon-small" src="/icons/teams/{{ $fixtureData['fixture']->team_2 }}.ico" />
                            <span class="fixture-team-name away-team-name">{{ $fixtureData['fixture']->team2->name }}</span>
                        </td>
                    @foreach ($fixtureData['predictions'] as $prediction)
                        <td class="td-center">{{ $prediction->result?->abbr }}</td>
                    @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>


        </div>


    </div>
@endsection
