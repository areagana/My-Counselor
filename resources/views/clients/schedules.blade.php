@Extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('client.schedules',$client,$client->id)}}
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
            <h2 class="header bg-light">Client: {{$client->name}}
                <span class="right">
                    <button class="btn btn-primary btn-sm" data-toggle='modal' href='#schedules_{{$client->id}}'><i class="fa fa-plus-circle"></i> Schedule</button>
                </span>
            </h2>
            <span class="right">
                <b>Key:</b>  <i class="fa fa-arrow-up text-primary" aria-hidden="true"> - Upcoming</i>&nbsp;&nbsp;&nbsp;&nbsp;
                <i class="fa fa-check text-success" aria-hidden="true">- Complete</i>&nbsp;&nbsp;&nbsp;
            </span>
            <div class="p-2">
                <h4 class="header">Schedules</h4>
                <div class="p-2">
                    @foreach($schedules as $schedule)
                        <div class="header p-3 document-display">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                            {{$schedule->client->name}} (<span class='text-muted'>{{$schedule->topic}}</span>)
                            @if(date_create($schedule->date) > date_create(date('Y-m-d H:m:s')))
                                <span class="right">
                                    {{date_format(date_create($schedule->date),"D jS M-y")}}
                                    <i class="fa fa-arrow-up text-primary" aria-hidden="true"> Upcoming</i> 
                                    , {{date_format(date_create($schedule->date),"H:m")}}
                                </span>
                            @else
                                <span class="right">
                                    {{date_format(date_create($schedule->date),"D jS M-y")}} at {{date_format(date_create($schedule->date),"H:m")}}
                                    <i class="fa fa-check text-success btn-circle btn-sm btn-light" aria-hidden="true"></i>
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- new schedules for client-->
        <div class='modal fade' id='schedules_{{$client->id}}'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header'>
						<h3 class='modal-title'>New Schedule</h3>
							<button type='button' class='close' data-dismiss='modal'>&times;</button>
					</div>
					<div class='modal-body'>
                        <div class="p-2">
                            <form action="{{route('schedule.store')}}" method='POST' id='form-schedule{{$client->id}}'>
                                @csrf
                                <div class="form-group">
                                    <label for="client_id_schedule" class="form-label">Client Name</label>
                                    <input type="text" class="custom-input" id='client_id_schedule' value="{{$client->name}}" required readonly>
                                    <input type="hidden" class="custom-input" name='client_id' id='client_id' value="{{$client->id}}">
                                    <div class="search-results-schedule bg-white shadow-sm"></div>
                                </div>
                                <div class="form-group">
                                    <label for="time" class="form-label">Issue</label>
                                    <select name="schedule-issues" id="schedule-issue" class="custom-select">
                                        <option value="" hidden>Select</option>
                                        @foreach($client->issues as $issued)
                                            <option value="{{$issued->id}}">{{$issued->issue_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="schedule-topic" class="form-label">Topic</label>
                                    <input type="text" name='schedule-topic' class="custom-input" id="schedule-topic" placeholder='Type Topic...' autocomplete='off'>
                                </div>
                                <div class="form-group">
                                    <label for="schedule-date" class="form-label">Date & start time</label>
                                    <input type="datetime-local" class="custom-input" name='schedule-date' id='schedule-date' required>
                                </div>
                                <div class="form-group">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="time" class="custom-input" name='end_time' id='end_time' required>
                                </div>
                            </form>
                        </div>
					</div>
					<div class='modal-footer'>
					    <button type='button' class='btn btn-light btn-sm' data-dismiss='modal'>Close</button>
						<button type='submit'class='btn btn-primary btn-sm' form ='form-schedule{{$client->id}}'>Save</button>
					</div>
				</div>
			</div>
		</div>
    </div>
@endsection