@extends('layouts.admin')

@section('content')
    <div class="">
        <div class="card p-0">
            <div class="card-body">
                <h3>
                    <i class="fa fa-list"></i> Browse Categories
                </h3>
                <a href="{{ route('admin.category.create') }}" class="btn btn-primary my-2" style="float: right"> <i
                        class="fa fa-plus"></i> Add new category</a>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Stories
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        {{ $category->id }}
                                    </td>
                                    <td>
                                        {{ $category->name }}
                                    </td>
                                    <td>
                                        {{ $category->news_count }}
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('admin.category.edit', $category) }}"><i
                                                class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
