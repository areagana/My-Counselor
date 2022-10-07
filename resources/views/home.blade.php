@extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('home')}}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 shadow-sm bg-white m-1 p-2 justify-content-center">
            <h4 class="header">Schedules
                <spa class="right">
                    <h5 class="text-muted">
                        Upcoming
                        <a href="/schedule" class="nav-link"> View All </a>
                    </h5>
                </spa>
            </h4>
            <div class="p-1 home-dash-schedules">
                <!--up coming schedules are displayed here-->
            </div>
        </div>
        <div class="col-md-5 shadow-sm bg-white m-1 p-2 justify-content-center home-dash">
            <h4 class="header">Clients Per Category</h4>
            <div class="p-1">
                @foreach(Auth::user()->categories as $category)
                <li class="list-group-item">
                   {{$category->category_name}}:
                   <span class="right">
                       {{count($category->clients)}}
                   </span>
                </li>
                @endforeach
            </div>
        </div>
    </div>
    
</div>
@endsection
