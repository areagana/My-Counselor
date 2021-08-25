@extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('client.edit',$client->id)}}
@endsection
@section('content')
<div class="container">
    <div class="col-md-12 shadow-sm bg-white p-2">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4 bg-white p-2 shadow-sm">
                        <img src="{{ asset('Client_profiles/'.$client->profile_image_url) }}" alt="" width='100px' height='110px'/>
                        <button class="btn btn-sm btn-info edit-profile" id='edit-profile'><i class="fa fa-edit"></i></button>

                        <form action="{{route('client.update',$client->id)}}" method='POST' enctype='multipart/form-data' class='choose-image-form'>
                            @csrf
                            <div class="form-group">
                                <input type="file" name='file' class="form-control">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success btn-sm" type='submit'>Upload</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <h3>
                            Edit {{$client->name}}
                        </h3>   
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('client.update',$client->id)}}" method='POST' id='edit_client'>
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name='name' id='name' value='{{$client->name}}' required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="custom-select">
                            <option value="{{$client->gender}}">{{$client->gender}}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="age" class="form-label">Age</label>
                        <input type="text" class="form-control" name='age' id='age' value='{{$client->age}}' required>
                    </div>
                    <div class="form-group">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" id="category" class="custom-select" value=''>
                            <option value="{{$client->category_id}}" hidden>{{$category_client->category_name}}</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </form>
            </div>
            <div class="card-footer">
                <span class="right">
                    <button class="btn btn-primary" type='submit' form='edit_client'>Save</button>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
