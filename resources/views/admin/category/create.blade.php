@extends('layouts.admin')

@section('content')
    <div class="">
        <div class="card p-0">
            <div class="card-body">
                <h3>
                    <i class="fa fa-plus"></i> Category create
                </h3>

                <a href="{{ route('admin.category.index') }}">Categories</a> <span>/</span> <span>Create</span>
                <br>
                <br>
                <br>
                <form action="{{ route('admin.category.store') }}" method="POST">
                    @csrf
                    @include('admin.category.includes.form', ['category' => $category])
                </form>
            </div>
        </div>
    </div>
@endsection
