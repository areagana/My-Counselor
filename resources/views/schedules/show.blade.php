@extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('schedule')}}
@endsection
@section('content')
    <div class="container">
        <div class="p-2 bg-white shadow-sm">
            <h3 class="header">
                Schedule
                <span class="right">
                    <a href="{{route('schedule.create')}}" class="nav-link">
                        <button class="btn btn-sm btn-primary" id='new-shadule'><i class="fa fa-plus-circle"></i> Schedule</button>
                    </a>    
                </span>
            </h3>
            <div class="p-2">
                <h5 class="header">
                    Upcoming
                </h5>
                <div class="p-2" id="upcoming-schedules">
            <!-- display the upcoming events here-->
                </div>
            </div>
            <div class="p-2">
                <h5 class="header">
                    Previous Schedules
                </h5>
                <!-- display previous schedules-->
                <div class="p-2" id="previous-schedules">

                </div>
            </div>
        </div>
    </div>
@endsection