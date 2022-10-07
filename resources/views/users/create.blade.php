@Extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('users')}}
@endsection
@section('content')
    <div class='container p-2'>
        <div class='p-2 bg-white shadow-sm'>
            <h3 class='header'>
                Users
                <span class='right'>
                    <a href="{{route('users.create')}}" class='nav-link'>
                        <button class='btn btn-sm btn-success'><i class='fa fa-plus-circle'></i> Users</button>
                    </a>
                </span>
            </h3>
            <div class='p-2'>
                @foreach($users as $user)
                    <div class='header row'>
                        <div class='col'>
                             {{$user->firstName}} {{$user->lastName}}
                        </div>
                        <div class='col'>
                            {{$user->email}}
                        </div>
                        <div class='col'>
                            {{$user->contact}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
    </div>
@endsection