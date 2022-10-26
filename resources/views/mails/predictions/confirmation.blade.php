@component('mail::message')
# {{ $name }}, your predictions have been saved
<br />
<table class="table table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Home</th>
            <th>Away</th>
            <th>Prediction</th>
        </tr>
    </thead>
    <tbody>
    @foreach($userPredictions as $userPrediction)
        <tr>
            <td style="padding-left: 5px;">{{ $userPrediction->fixture->fixture_date->format('D M j g:ia') }}</td>
            <td style="padding-left: 10px;">{{ $userPrediction->fixture->team1->name }}</td>
            <td style="padding-left: 10px;">{{ $userPrediction->fixture->team2->name }}</td>
            <td style="padding-left: 5px; text-align: center">{{ $userPrediction->result->abbr }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br />
Thanks,<br>
{{ config('app.name') }}
@endcomponent
