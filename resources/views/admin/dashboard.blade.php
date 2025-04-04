@extends('layouts.admin')

<style>
    .font-size{
        font-size: 2rem;
        font-weight: 800 !important;
    }
</style>

@section('content')
    <h1>Dashboard</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body d-flex justify-content-between">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text font-size mt-4">{{ $users }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body d-flex justify-content-between">
                    <h5 class="card-title">Total News</h5>
                    <p class="card-text font-size mt-4">{{ $allNewsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body d-flex justify-content-between">
                    <h5 class="card-title">Total Commments</h5>
                    <p class="card-text font-size mt-4">{{ $allCommentsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card">
                <div class="card-header">
                    Recent News
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($recentNews as $news)
                            <li class="list-group-item">{{ $news->title }}</li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card">
                <div class="card-header">
                    Recent Users
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($recentUser as $user)
                            <li class="list-group-item">{{ $user->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
