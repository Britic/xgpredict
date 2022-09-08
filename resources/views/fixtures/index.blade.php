@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <h3>Fixtures</h3>
        </div>

        <table class="table table-striped table-dark">
            <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Competition</th>
                <th>Home Team</th>
                <th>Away Team</th>
            </tr>
            </thead>
            <tbody>
            @foreach($fixtures as $fixture)
                <tr class="predictionRow">
                    <td>{{ $fixture->fixture_date->format('l, F j') }}</td>
                    <td>{{ $fixture->fixture_date->format('g:ia') }}</td>
                    <td>{{ $fixture->league->abbr }}</td>
                    <td>
                        <img class="icon-small" src="/icons/teams/{{ $fixture->team_1 }}.ico" />
                        <span class="fixture-team-name home-team-name">{{ $fixture->team1->name }}</span>
                    </td>
                    <td>
                        <img class="icon-small" src="/icons/teams/{{ $fixture->team_2 }}.ico" />
                        <span class="fixture-team-name away-team-name">{{ $fixture->team2->name }}</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
