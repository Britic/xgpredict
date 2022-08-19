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
                <th>Prediction</th>
            </tr>
            </thead>
            <tbody>
            @foreach($fixtures as $fixture)
            <tr>
                <td>{{ $fixture->fixture_date->format('l, F j') }}</td>
                <td>{{ $fixture->fixture_date->format('g:ia') }}</td>
                <td>{{ $fixture->league->abbr }}</td>
                <td>{{ $fixture->team1->name }}</td>
                <td>{{ $fixture->team2->name }}</td>
                <td>
                    <select style="width: 40px;">
                        <option>-</option>
                        <option>H</option>
                        <option>A</option>
                        <option>D</option>
                    </select>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
