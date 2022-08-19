@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <h3>Standings</h3>
        </div>


        <div class="row">
            <div class="col-md-4">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Predictions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($standings as $standing)
                        <tr>
                            <td>{{ $standing->rank }}</td>
                            <td>{{ $standing->name }}</td>
                            <td>{{ $standing->score }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection
