@extends('layouts.app')

@section('content')
    <div class="container">

        <h3>Submit Your Predictions: <small>{{ $round->name }}</small></h3>
        <hr />
        <div class="row">
            <h3>Fixtures</h3>
        </div>

        <form method="post">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}" />

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
                    <td>
                        <select class="form-control selectPrediction" name=predictions[{{ $predictions[$fixture->id]->id }}] style="padding: 5px 10px;">
                            <option value="">- Select</option>
                            <option value="1"{{ (($predictions[$fixture->id]->predicted_result_id == 1) ? ' selected' : '') }}>H - {{ $fixture->team1->name }}</option>
                            <option value="2"{{ (($predictions[$fixture->id]->predicted_result_id == 2) ? ' selected' : '') }}>A - {{ $fixture->team2->name }}</option>
                            <option value="3"{{ (($predictions[$fixture->id]->predicted_result_id == 3) ? ' selected' : '') }}>Draw</option>
                        </select>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
            @csrf
            <button type="submit" class="btn btn-large btn-outline-success float-end">Submit Predictions</button>

        </form>

    </div>

    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", function() {
            highlightSelections();
        });

        let predictionSelects = document.querySelectorAll('select.selectPrediction');
        predictionSelects.forEach(select => {
            select.addEventListener('change', highlightSelections);
        });


        function highlightSelections() {

            let tableRows = document.querySelectorAll('tr.predictionRow');

            document.querySelectorAll('span.fixture-team-name').forEach(function(elem) {
                elem.classList.remove('fixture-selected');
                elem.classList.remove('fixture-rejected');
                elem.classList.remove('draw-selected');
            });

            tableRows.forEach(function(tableRow) {
                let prediction = tableRow.querySelector('.selectPrediction');


                switch (prediction.value) {
                    case '1':
                        tableRow.querySelector('.home-team-name').classList.add('fixture-selected');
                        tableRow.querySelector('.away-team-name').classList.add('fixture-rejected');
                        break;

                    case '2':
                        tableRow.querySelector('.away-team-name').classList.add('fixture-selected');
                        tableRow.querySelector('.home-team-name').classList.add('fixture-rejected');
                        break;

                    case '3':
                        tableRow.querySelector('.home-team-name').classList.add('draw-selected');
                        tableRow.querySelector('.away-team-name').classList.add('draw-selected');
                        break;
                }
            });

        }

    </script>
@endsection
