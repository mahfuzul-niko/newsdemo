@extends('layouts.admin')

@section('content')
    <div class="">
        <div class="card p-0">
            <div class="card-body">
                <h3>
                    <i class="fa fa-edit"></i> {{ $category->name }} edit
                </h3>
                <a href="{{ route('admin.category.index') }}">Categories</a> <span>/</span> <span>Edit</span>
                <br>
                <br>
                <br>
                <form action="{{ route('admin.category.update',$category) }}" method="POST">
                    @csrf
                    @method('put')
                    @include('admin.category.includes.form', ['category' => $category])
                </form>
            </div>
        </div>
    </div>
@endsection
