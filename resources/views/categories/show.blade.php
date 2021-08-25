@extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('category')}}
@endsection
@section('content')
    <div class="container">
        @if(session('success'))
        <div class="bg-white p-2">
            <div class="alert alert-success alert-dismissible">
                <button class="close" data-dismiss='alert'>&times;</button>
                {{session('success')}}
            </div>
        </div>
        @endif
        <div class="p-2 row">
            <div class="bg-white col shadow-sm mx-1">
                <h4 class="header p-2">Client Categories
                    <span class="right">
                        <a href="/category/create" class="nav-link">Add Category</a>
                    </span>
                </h4>
                @foreach($categories as $category)
                    <div class="p-2 custom-link">
                        {{$category->category_name}}
                        <span class="right">
                            <i class="fa fa-ellipsis-v btn btn-sm btn-circle btn-light" onclick="showForm('more_info_{{$category->id}}')"></i>
                        </span>                        
                        <div class="p-2 bg-white shadow-sm more-info-toggle" id='more_info_{{$category->id}}'>
                            <h5 class="header">More</h5>
                            <div class="p-2">
                                <a href="{{url('/category/'.$category->id.'/edit')}}" class="nav-link"><i class="fa fa-edit"></i> Edit</a>
                                <a href="{{url('/categories/'.$category->id.'/documents')}}" class="nav-link"><i class="fa fa-file"></i> Documents</a>
                                <a href="{{url('/categories/'.$category->id.'/schedules')}}" class="nav-link"><i class="fa fa-clock"></i> Schedules</a>
                                <a href="{{url('/categories/'.$category->id.'/clients')}}" class="nav-link"><i class="fa fa-user"></i> Clients</a>
                                <a  class="nav-link" data-toggle='modal' href='#form_category_delete{{$category->id}}'><i class="fa fa-trash"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                    <div class='modal fade' id='form_category_delete{{$category->id}}'>
						<div class='modal-dialog'>
							<div class='modal-content'>
								<div class='modal-header'>
									<h3 class='modal-title'>Confirm</h3>
									<button type='button' class='close' data-dismiss='modal'>&times;</button>
								</div>
								<div class='modal-body'>
                                    <form action="{{route('category.delete',$category->id)}}" method='POST' id='category_delete{{$category->id}}'>
                                        @csrf
                                        Are you sure you want to delete this category?<br>
                                        <b>Remember</b>, You will lose all information attached to it.
                                    </form>
								</div>
								<div class='modal-footer'>
									<button type='button' class='btn btn-light btn-sm' data-dismiss='modal'>Close</button>
									<button type='submit' class='btn btn-primary btn-sm'  form ='category_delete{{$category->id}}'>Confirm</button>
								</div>
							</div>
						</div>
					</div>

                @endforeach
            </div>
                @if(isset($title))
                <div class="col bg-white shadow-sm mx-1">
                    @if($title=='create')
                    <h4 class="header p-2">New Category </h4>
                    <div class="p-2">
                        <form action="{{route('category.store')}}" method='POST'>
                            @csrf
                            <div class="fom-group">
                                <label for="" class="form-label">Category Name</label>
                                <input type="text" class="custom-input" name='category_name' required autofocus autocomplete='off'>
                            </div>
                            <div class="fom-group">
                                <label for="" class="form-label">Description</label>
                                <input type="text" class="custom-input" name='category_details' required autocomplete='off'>
                            </div>
                            <div class="form-group m-2">
                                <button class="btn btn-light right">Save</button>
                            </div>
                        </form>
                    </div>
                    @elseif($title='edit')
                    <h4 class="header p-2">Edit {{$category_select->category_name}} </h4>
                    <div class="p-2">
                        <form action="{{route('category.update',$category_select->id)}}" method='POST'>
                            @csrf
                            <div class="fom-group">
                                <label for="" class="form-label">Category Name</label>
                                <input type="text" class="custom-input" name='category_name' value="{{$category_select->category_name}}" required>
                            </div>
                            <div class="fom-group">
                                <label for="" class="form-label">Description</label>
                                <input type="text" class="custom-input" name='category_details' value="{{$category_select->category_details}}" required>
                            </div>
                            <div class="form-group m-2">
                                <button class="btn btn-light right">Save</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
                @endif
        </div>
    </div>
@endsection