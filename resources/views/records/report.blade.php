@Extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('reports')}}
@endsection
@section('content')
    <div class="container">
        <div class="h4 p-3 header bg-white">Reports
            <span class="right h6">
                <a href="" class="nav-link btn btn-outline-primary btn-sm"><i class="fa fa-print"></i> Print</a>
            </span>
        </div>
        <div class="p-2 bg-white mt-1">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#issues" class="nav-link" data-toggle='tab'>Issues</a>
                </li>
                <li class="nav-item">
                    <a href="#clients" class="nav-link" data-toggle='tab'>Clients</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane p-2 mt-2" id="issues">
                    <div class="p-2 border-bottom">
                        <div class="header h5 text-primary">Filter Data by</div>
                        <label for="" class="form-label">Start Date
                            <input type="date" name="" id="start_date" class="form-control form-control-sm" onchange="checkDate($(this).val(),$('#end_date').val())">
                        </label>
                        <label for="" class="form-label">End Date
                            <input type="date" name="" id="end_date" class="form-control form-control-sm" max="{{date('Y-m-d')}}" onchange="checkDate($('#start_date').val(),$(this).val())">
                        </label>
                        <label for="category_name" class="form-label">Category
                            <select name="" id="category_name" class="form-control form-control-sm" onchange="fetchIssuesCategory($(this).val())">
                                <option value="" hidden>Select</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label for="category_name" class="form-label">Status
                            <select name="" id="category_name" class="form-control form-control-sm" onchange="fetchIssuesStatus($(this).val())">
                                <option value="">Select</option>
                                @foreach($statuses as $status)
                                    <option value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="p-2">
                        <div class="header text-primary">Results</div>
                        <div class="results p-1">

                        </div>
                    </div>
                </div>
                <div class="tab-pane p-2 mt-2" id="clients">
                    Clients
                </div>
            </div>
        </div>
    </div>
@endsection