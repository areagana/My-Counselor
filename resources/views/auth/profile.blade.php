@Extends('layouts.app')
@section('crumbs')

@endsection
@section('content')
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
    <div class="container">
        <div class="row p-2 bg-white shadow-sm">
            <div class="col">
                <h3 class="header">{{Auth::user()->firstName}}'s Profile</h3>
            </div>
        </div>
        <div class="row bg-white shadow-sm">
            <div class="col-md-4 p-3">
                <img src="{{ asset('User_profile/'.Auth::user()->profile_image_url) }}" alt="" height='340px' width='320px' class='edit-profile'/>
                <span class='image-info'><i>Click image to edit</i></span>
                <form action="{{route('profileImage.update',Auth::user()->id)}}" method='POST' enctype='multipart/form-data' class='choose-image-form'>
                    @csrf
                    <div class="form-group">
                        <input type="file" name='file' class='custom-input choose-file'>
                    </div>
                    <i class="fa fa-times cancel btn btn-light btn-sm"> Cancel</i>
                    <button class="btn btn-sm btn-primary right upload" type='submit'><i class="fa fa-arrow-up"></i> Upload</button>
                </form>
            </div>
            <div class="col p-3">
                <form action="{{route('profile.update',Auth::user()->id)}}" method='POST'>
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">First Name:</label>
                        <input type="text" name='firstName' class="custom-input" value='{{Auth::user()->firstName}}'>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Last Name:</label>
                        <input type="text" name='lastName' class="custom-input" value='{{Auth::user()->lastName}}'>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Gender:</label>
                        <input type="text" name='gender' class="custom-input" value='{{Auth::user()->gender}}'>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Email:</label>
                        <input type="text" name='email' class="custom-input" value='{{Auth::user()->email}}'>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Contact:</label>
                        <input type="text" name='contact' class="custom-input" value='{{Auth::user()->contact}}'>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary right" type='submit'>Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row p-3 bg-white shadow-sm">

        </div>
    </div>
@endsection