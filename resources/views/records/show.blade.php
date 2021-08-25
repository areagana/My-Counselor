@extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('records')}}
@endsection
@section('content')
    <div class="container">
        <div class="bg-white p-2 shadow-sm">
            <h3 class="header">Records</h3>
            <div class="p-2">
                @foreach($records as $record)
                    <div class="p-2 header records-display" data-toggle='collapse' href='#record_{{$record->id}}'>
                        {{$record->client->name}} (<span class='text-muted'>{{$record->client->category->category_name}}</span>)
                        <span class="right text-muted">
                            {{date_format(date_create($record->created_at),"D jS-M-y")}}
                        </span>
                    </div>
                    <div class="collapse p-2" id='record_{{$record->id}}'>
                        <p class="p-2">
                            <h5>Shared Info</h5>
                            {{$record->shared_info}}
                        </p>
                        <p class="p-2">
                            <h5>Resolution</h5>
                            {{$record->resolution}}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection