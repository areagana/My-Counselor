@extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('client.create')}}
@endsection
@section('content')
<div class="container">
<div class="col-md-12 shadow-sm bg-white p-3">
        <div class="card p-2">
            <div class="card-header">
                <h3>New Client </h3>
            </div>
            <div class="card-body">
                <form action="{{route('client.store')}}" method='POST' id='new_client'>
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name='name' id='name' autofocus autocomplete='off' required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="custom-select">
                            <option value="" hidden>Select </option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="age" class="form-label">Age</label>
                        <input type="text" class="form-control" name='age' id='age' autocomplete='off' required>
                    </div>
                    <div class="form-group">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" id="category" class="custom-select">
                            <option value="" hidden>Select </option>
                            @foreach(Auth::user()->categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <span class="right">
                    <button class="btn btn-primary" type='submit' form='new_client'>Save</button>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
