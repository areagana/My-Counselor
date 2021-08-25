@Extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('category.clients',$category->id)}}
@endsection
@section('content')
    <div class="container p-2">
        @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif
        @if(session('error'))
            <div class="p-2 error-message">
                {{session('error')}}
            </div>
        @endif
        <div class="p-2 bg-white shadow-sm">
            <h2 class="header bg-light">Category: {{$category->category_name}}</h2>
            <div class="p-2">
                <h4 class="header">Clients</h4>
                <div class="p-2">
                    @foreach($clients as $client)
                        <div class="header p-3 document-display">
                        <img src="{{ asset('Client_profiles/'.$client->profile_image_url) }}" alt="" height='40px' width='40px' class='profile-circle'/> 
                            {{$client->name}}
                            <span class="right">
                                <i class="fa fa-ellipsis-v btn btn-sm btn-circle btn-light" onclick="showForm('client_{{$client->id}}')"></i>
                            </span>

                            <div class="p-2 bg-white shadow more-info-toggle" id='client_{{$client->id}}'>
                                <a href="{{url('/client/'.$client->id.'/view')}}" class="nav-link">Records</a>
                                <a href="{{route('client.schedules',$client->id)}}" class="nav-link">Schedules</a>
                                <a href="{{route('client.profile',$client->id)}}" class="nav-link">Profile</a>
                            </div>
                        </div>
                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection