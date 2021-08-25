@Extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('category.schedules',$category->id)}}
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
            <h2 class="header bg-light">Category: {{$category->category_name}}
                    <span class="right current-time"></span></h2>
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
                            {{$schedule->topic}}
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
                <div class="mb-0 bg-light text-info p-3 justify-content-center">
                    To add more schedules to this category, go to schules and select members of this category
                </div>
            </div>
        </div>
    </div>
@endsection