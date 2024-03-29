@extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('client.view',$client->id)}}
@endsection
@section('content')
<div class="container">
    <div class="shadow-sm bg-white p-2">
        <h3 class="header">
            {{$client->name}}
            <span class="right">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button class="close" data-dismiss='alert'>&times;</button>
                        {{session('success')}}
                    </div>
                @endif
            </span>
        </h3>
        <div class="row">
            <div class="col-md-3">
                <img src="{{asset('/images/man-with-question-01.png')}}" alt="Profile Photo" class='profile-image'></img>
            </div>
            <div class="col-md-9">
                <h5 class="header p-3">Background information
                    <span class="right">
                        <button class="btn btn-sm btn-info" onclick="AddBackgroundInfo()"><i class="fa fa-plus"> Add Info</i></button>
                    </span>
                </h5>
                <table class="table table-sm table-striped">
                    <thead class="custom-thead">
                        <tr>
                            <th>Alcohol</th>
                            <th>Drugs</th>
                            <th>Torture</th>
                            <th>Others</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($backgrounds as $bground)
                            <tr>
                                <td>{{$bground->alcohol}}</td>
                                <td>{{$bground->drugs}}</td>
                                <td>{{$bground->torture}}</td>
                                <td>{{$bground->others}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-2">
                    @foreach($otherinfos as $info)
                        <div class="p-2">
                            {{$info->other_info}}
                        </div>
                    @endforeach

                    <!-- form to hold textareas for more background information -->
                    <form action="{{route('backgroundInfo',$client->id)}}" method='POST'>
                        @csrf
                        <div class="input-group" id='background-info'>
                            <!-- Holds the textarea for the background information -->
                        </div>
                        <div class="form-row p-2">
                            <div class="col p-2">
                                <button class="btn btn-primary right btn-sm hidden" id='save_button'>Save Record</button>
                            </div>
                        </div>
                    </form>
                </div>            
            </div>
        </div>
        <div class="row p-2">
            <div class="col p-2" >

            </div>
        </div>
        <div class="row p-2">
            <div class="col-md-4 p-2">
                <h5 class="header">Issues
                    <span class="right">
                        <a href="issue/create" class="nav-link right">
                            <button class="btn btn-sm btn-light"><i class="fa fa-plus-circle"></i> Issue</button>
                        </a>
                    </span>
                </h5>
                @if(session('title') && session('title')=='new issue')
                    <div class="p-2">
                        <form action="{{route('issue.store')}}" method='POST'>
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name='client_id' value="{{$client->id}}">
                                <input type="hidden" name='category_id' value="{{$client->category_id}}">
                                <label for="" class="form-label">Issue Title</label>
                                <input type="text" class="custom-input" name='issue_title' autocomplete='off'>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Details</label>
                                <input type="text" class="custom-input" name='issue_details' autocomplete='off'>
                            </div>
                            <div class="form-group p-2 m-1">
                                <button class="btn btn-primary right" type='submit'>Save</button>
                            </div>
                        </form>
                    </div>
                @else
                    @foreach($client->issues as $issue)
                        <li class="custom-list">
                            <a href="{{route('record.create',$issue->id)}}" class="nav-link">
                                {{$issue->issue_title}}
                                <span class="right">
                                    {{$issue->status}}
                                </span>
                            </a>
                        </li>
                    @endforeach
                @endif
            </div>
            <div class="col p-2">
                @if(session('title') && session('title')=='new record')
                <h5 class="header">{{session('issue_select')->issue_title}}
                    <span class="right">
                        <a href="{{route('issue.edit',$issue->id)}}" class="nav-link">
                            <i class="fa fa-edit"></i>
                        </a>
                    </span>
                </h5>
                    <div class="p-2">
                        <div class="p-2">
                            <h5 class='header p-2'>Notes
                                <span class="right">
                                    <button class="btn btn-outline-danger btn-sm sub-issue-content" data-title="{{session('issue_select')->issue_title}}" data-issue="{{session('issue_select')->id}}"><i class="fa fa-plus"></i> Section</button>
                                </span>
                            </h5>
                            @foreach(session('issue_select')->records as $record)
                                <div class="p-2">
                                    {!! $record->shared_info !!}
                                    <span class="right">
                                        {{date_format(date_create($record->created_at),'D jS M y')}}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <form action="{{route('record.store')}}" method='POST'>
                            @csrf
                                <input type="hidden" name='client_id' value="{{$client->id}}">
                                <input type="hidden" name='category_id' value="{{$client->category_id}}">
                                <input type="hidden" name='issue_id' value="{{session('issue_select')->id}}">
                                <div class="form-group">
                                    <label class='form-label' for="topic_id">Topic</label>
                                    <select name="topic_id" id="topic_id" class='form-control'>
                                        <option value=""> Select</option>
                                        @foreach(session('issue_select')->topics as $topic)
                                            <option value="{{$topic->id}}">{{$topic->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            <div class="form-group">
                                <label for="" class="form-label">Key points</label>
                                <textarea type="text" class="form-control" name='issue_details' id='new-record-text'></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Progress</label>
                                <textarea type="text" class="form-control" name='issue_progress'></textarea>
                            </div>
                            <div class="form-group">
                                <h5 class='header'>Issue Status</h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="issue_status" id="status-complete" value="Complete">
                                    <label class="form-check-label" for="status-complete">Complete</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="issue_status" id="status-running" value="Running">
                                    <label class="form-check-label" for="status-running">Running</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="issue_status" id="status-stopped" value="Stopped">
                                    <label class="form-check-label" for="status-stopped">Stopped</label>
                                </div>
                            </div>
                            <div class="form-group p-2 m-1">
                                <button class="btn btn-primary right" type='submit'>Save</button>
                            </div>
                        </form>
                    </div>
                @else
                    <h5 class="header">Recent Records</h5>
                    @foreach($client->records as $record)
                        <li class="custom-list" data-toggle='modal' data-target='#form-record{{$record->id}}'>
                            {!!$record->shared_info!!}
                            <span class="right">
                            {{date_format(date_create($record->created_at),'D jS M y')}}
                            </span>
            <!-- modal to update the records entered-->
                        </li>
                            <div class='modal fade' id='form-record{{$record->id}}'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h3 class='modal-title'>Edit Record</h3>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body'>
                                            <form action="{{route('record.update',$record->id)}}" method='POST' id='edit-record{{$record->id}}'>
                                                @csrf
                                                
                                                <div class="form-group">
                                                    <input type="hidden" name='client_id' value='{{$client->id}}'>
                                                    <label for="shared_info" class="form-label">Key Points</label>
                                                    <textarea name="shared_info" id="shared_info" cols="50" rows="3" class="custom-input" value='{!!$record->shared_info!!}'>{!! $record->shared_info !!}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="progress" class="form-label">Progress</label>
                                                    <textarea name="progress" id="progress" cols="50" rows="3" class="custom-input" value='{!!$record->progress!!}'>{!! $record->progress !!}</textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-light btn-sm' data-dismiss='modal'>Cancel</button>
                                            <button type='submit' class='btn btn-primary btn-sm' form ='edit-record{{$record->id}}'>Save</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="sub-issue" tabindex="-1"  data-backdrop='static' role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sub_issue_title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('subissueStore')}}" method='POST' id='subIssue-form'>
            @csrf
            <div class="form-group">
                <label for="details">Title</label>
                <input type="hidden" name="issue_id" id='issue_id_subissue'>
                <input type="text" name ='title' id='title' class="form-control" required>
            </div>
            <div class="form-group">
                <label for="details">Details</label>
                <textarea type="text" name ='details' id='details' class="form-control" required></textarea>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form='subIssue-form'>Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
