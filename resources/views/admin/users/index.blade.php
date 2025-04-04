<!-- resources/views/admin/users/index.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Users Management</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-flex align-items-center  ">add &nbsp <i
                    class="fas fa-plus"></i></a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">

            <div class="card-body p-0 table-responsive">
                <table class="table table-hover  mb-0">
                    <thead class="">
                        <tr>
                            <form action="{{ route('admin.user.search') }}">
                                <td colspan="5">
                                    <input type="text" class="form-control px-4" style="border-radius: 2rem;"
                                        placeholder="Search..." name="q" value="{{ request()->q }}">
                                </td>
                                <td colspan="1">
                                    <button class="btn btn-success"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-danger"><i
                                            class="fas fa-undo"></i></a>
                                </td>
                            </form>
                        </tr>
                        <tr>
                            <th scope="col">Avatar</th>
                            <th scope="col">Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="align-middle text-center">
                                    @if ($user->avatar)
                                        <img src="{{ $user->getAvatar() }}" alt="{{ $user->name }}" class="rounded-circle"
                                            width="40" height="40">
                                    @else
                                        <div class="bg-secondary text-white rounded-circle d-inline-flex justify-content-center align-items-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $user->name }}</td>
                                <td class="align-middle">{{ $user->username }}</td>
                                <td class="align-middle">{{ $user->email }}</td>
                                <td class="align-middle">{{ ucfirst($user->role) }}</td>
                                <td class="align-middle">
                                    <div class="d-flex ">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger ml-1">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-center">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
