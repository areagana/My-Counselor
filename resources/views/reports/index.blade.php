<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h4>
                COUNSELING REPORT FOR THE DATES BETWEEN {{$start_date }} AND{{ $end_date }}
            </h4>
            <div class="p-2">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Issue</th>
                            <th>Sharing</th>
                            <th>Wayforward</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($issues as $issue)
                            <tr>
                                <td rowspan='{{ $issue->records->count()+1 }}'>{{ $issue->created_at }}</td>
                                <td rowspan='{{ $issue->records->count()+1 }}'>{{ $issue->client->name }}</td>
                                <td rowspan='{{ $issue->records->count()+1 }}'>{{ $issue->client->class }}</td>
                                <td rowspan='{{ $issue->records->count()+1 }}'>{{ $issue->title }}</td>
                            </tr>
                                @foreach($issue->records as $index => $record)
                                <tr>
                                    <td>{{ strip_tags($record->shared_info) }}</td>
                                    <td>{{ $record->progress }}</td>
                                </tr>
                                @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
