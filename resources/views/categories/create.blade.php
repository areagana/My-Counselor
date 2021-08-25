@extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('category')}}
@endsection
@section('content')
    <div class="container">
        <div class="p-2 row">
            <div class="bg-white col">
                <h4 class="header">Client Categories</h4>
            </div>
        </div>
    </div>
@endsection