@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Create New User</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Create User Form -->
        <div class="card custom-shadow border-0 p-4">
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <!-- Avatar -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" name="avatar" class="form-control" id="avatar">
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" id="username"
                                    value="{{ old('username') }}" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" id="country"
                                    value="{{ old('country') }}">
                            </div>
                        </div>

                        <!-- State -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" class="form-control" id="state"
                                    value="{{ old('state') }}">
                            </div>
                        </div>

                        <!-- City -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" class="form-control" id="city"
                                    value="{{ old('city') }}">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" id="address"
                                    value="{{ old('address') }}">
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" name="website" class="form-control" id="website"
                                    value="{{ old('website') }}">
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea name="bio" class="form-control" id="bio">{{ old('bio') }}</textarea>
                            </div>
                        </div>

                        <!-- Locale -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="locale" class="form-label">Locale</label>
                                <input type="text" name="locale" class="form-control" id="locale"
                                    value="{{ old('locale', 'en') }}">
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="password_confirmation" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-dark w-100">Create User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
