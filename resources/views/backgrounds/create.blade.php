@extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('client.background',$client->id)}}
@endsection
@section('content')
<div class="container">
    <div class="col-md-12 shadow-sm bg-white p-2">
        <div class="card">
            <div class="card-header">
                <h3>Background information for {{$client->name}}</h3>
            </div>
            <div class="card-body">
                <form action="{{route('background.store')}}" method='POST' id='new-background'>
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name='client_id' value="{{$client->id}}">
                        <div class="p-1">
                            Do you Take Alcohol?
                        </div>
                        <label for="alcohol-yes" class="form-label mx-4">
                            <input type="radio" class="form-control mx-4" name='alcohol' id='alcohol-yes' value='Yes'>
                             Yes
                        </label>
                        <label for="alcohol-no" class="form-label mx-4">
                            <input type="radio" class="form-control mx-4" name='alcohol' id='alcohol-no' value='No'>
                             No
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="p-1">
                            Have you ever consumed any drug?
                        </div>
                        <label for="drug-yes" class="form-label mx-4">
                            <input type="radio" class="form-control mx-4" name='drugs' id='drug-yes' value='Yes'>
                             Yes
                        </label>
                        <label for="drug-no" class="form-label mx-4">
                            <input type="radio" class="form-control mx-4" name='drugs' id='drug-no' value='No'>
                             No
                        </label>
                    </div>
                    <div class="form-group form-radio">
                        <div class="p-1">
                            Have you ever been  tortured?
                        </div>
                        <label for="torture-yes" class="form-label mx-4">
                            <input type="radio" class="form-control mx-4" name='torture' id='torture-Yes' value='Yes'>
                             Yes
                        </label>
                        <label for="torture-no" class="form-label mx-4">
                            <input type="radio" class="form-control mx-4" name='torture' id='torture-no' value='No'>
                             No
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="p-1">
                            Any other information?
                        </div>
                        <label for="other-yes" class="form-label mx-4">
                            <input type="radio" class="form-control mx-4" name='other' id='other-yes' value='Yes'>
                             Yes
                        </label>
                        <label for="other-no" class="form-label mx-4">
                            <input type="radio" class="form-control mx-4" name='other' id='other-no' value='No'>
                             No
                        </label>
                    </div>
                    <div class="form-group more-info-background">
                        Other information
                        <textarea name="other-info" id="other-info" class='form-control' cols="70" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <span class="right">
                    <button class="btn btn-primary" type='submit' form='new-background'>Save</button>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
