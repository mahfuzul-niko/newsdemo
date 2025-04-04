<!-- resources/views/admin/pages/create.blade.php -->

@extends('layouts.admin')
@section('css')

    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    
@endsection
@section('content')
    <div class="container">
        <h1 class="mb-4">Create New Page</h1>

        <div class="card custom-shadow border-0 p-4">
            <form action="{{ route('admin.pages.store') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text"  class="form-control" id="slug" value="" >
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" class="form-control" id="summernote" rows="5" required>{{ old('content') }}</textarea>
                </div>


                <button type="submit" class="btn btn-primary">Create Page</button>
            </form>
        </div>
    </div>
@section('js')
    


<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        $('#summernote').summernote({
            placeholder: 'Page Content Here',
            tabsize: 2,
            height:500
        });
    </script>
@endsection
@endsection
