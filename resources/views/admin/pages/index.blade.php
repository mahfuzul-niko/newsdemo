@extends('layouts.admin')

@section('content')
    <div class="">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Pages</h1>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary mb-3">Create New Page</a>
        </div>
        <!-- Display success messages -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif


        <!-- Pages Table -->
        <div class="card">
            <div class="card-header">
                Pages List
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $index => $page)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->created_at->format('Y-M-d') }}</td>

                                <td class="d-flex ">
                                    <a href="{{ route('admin.pages.edit', $page->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm ml-1">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $pages->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
