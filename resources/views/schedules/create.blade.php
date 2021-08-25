@extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('schedule.create')}}
@endsection
@section('content')
    <div class="container">
        <div class="p-2 bg-white shadow-sm">
            <h3 class="header">
                New Schedule
            </h3>
            <div class="p-2">
            <form action="{{route('schedule.store')}}" method='POST'>
                @csrf
                <div class="form-group">
                    <label for="client_id_schedule" class="form-label">Client Name</label>
                    <input type="text" class="custom-input" id='client_id_schedule' required placeholder='Type name..' autocomplete='off'>
                    <input type="hidden" class="custom-input" name='client_id' id='client_id'>
                    <div class="search-results-schedule bg-white shadow-sm"></div>
                </div>
                <div class="form-group">
                    <label for="time" class="form-label">Issue</label>
                    <select name="schedule-issues" id="schedule-issues" class="custom-select">
                        <option value="" hidden>Select</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="schedule-topic" class="form-label">Topic</label>
                    <input type="text" name='schedule-topic' class="custom-input" id="schedule-topic" placeholder='Type Topic...'>
                </div>
                <div class="form-group">
                    <label for="schedule-date" class="form-label">Date & start time</label>
                    <input type="datetime-local" class="custom-input" name='schedule-date' id='schedule-date' required>
                </div>
                <div class="form-group">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="time" class="custom-input" name='end_time' id='end_time' required>
                </div>
                <div class="p-2 justify-content-right">
                    <span class="">
                        <button class="btn btn-primary" type='submit'>Save</button>
                    </span>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection