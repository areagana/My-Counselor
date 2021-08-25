@Extends('layouts.app')
@section('crumbs')
    {{Breadcrumbs::render('category.documents',$category->id)}}
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
                <span class="right">
                   <button class="btn btn-sm btn-info new-doc-btn"><i class="fa fa-plus"></i> Doc</button>
                </span>
            </h2>
            <div class="header shadow-sm new-doc-form">
                <form action="{{route('categoryDocument.upload',$category->id)}}" method='POST' enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <label for="document" class="form-label">Add New document
                            <input type="file" name='document' id='document' class="custom-input" required>
                        </label>
                        <label for="document_title" class="form-label">Document title
                            <input type="text" class="custom-input" name ='document_title' id="document_title" placeholder='Title' required>
                            <input type="hidden" name='category_id' value="{{$category->id}}">
                        </label>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm right" type='submit'>Upload</button>
                    </div>
                </form>
                <p class='text-danger'><i>Only PDF, WORD, EXCEL and POWERPOINT documents are allowed</i></p>
            </div>
            <div class="p-2">
                <h4 class="header">Uploaded documets</h4>
                <div class="p-2">
                    @foreach($documents as $document)
                        <div class="header p-3 document-display">
                        <i class="fa fa-file" aria-hidden="true"></i> 
                            {{$document->document_title}}
                            <span class="right">
                                <a href="{{route('download.document',$document->id)}}" class="nav-link custom-btn-primary">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection