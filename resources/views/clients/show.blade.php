@extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('clients')}}
@endsection
@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button class="close" data-dismiss='alert'>&times;</button>
            {{session('success')}}
        </div>
    @endif
    <div class="col-md-12 shadow-sm bg-white p-2">
        <div class="card">
            <div class="card-header">
                <h3>My Clients
                    <span class="right">
                        <a href="/clients/create" class="nav-link btn btn-info btn-sm">
                            <i class="fa fa-plus-circle"></i> New Client
                        </a>
                    </span>
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-striped table-sm">
                    <thead class="custom-thead">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Section</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($clients as $client)
                            <tr>
                                <td></td>
                                <td>{{$client->name}}</td>
                                <td>{{$client->gender}}</td>
                                <td>{{$client->category->category_name}}</td>
                                <td>
                                    <i class="fa fa-ellipsis-v btn btn-sm btn-circle btn-light" onclick="showForm('client_{{$client->id}}')"></i>
                                    <div class="p-2 bg-white shadow more-info-toggle" id='client_{{$client->id}}'>
                                        <a href="{{url('/client/'.$client->id.'/view')}}" class="nav-link">Records</a>
                                        <a href="{{route('client.schedules',$client->id)}}" class="nav-link">Schedules</a>
                                        <a href="{{route('client.profile',$client->id)}}" class="nav-link">Profile</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>
@endsection
