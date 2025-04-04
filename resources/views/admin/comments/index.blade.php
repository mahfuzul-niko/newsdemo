<!-- resources/views/admin/comments/index.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Comments Management</h1>
        </div>

        <!-- Display errors or success messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- <!-- Comments Table -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Comments List</h5>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Comment</th>
                            <th>User</th>
                            <th>News</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $index => $comment)
                            <tr>
                                <td class="align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle">{{ Str::limit($comment->comment, 60, '...') }} </td>
                                <td class="align-middle">{{ $comment->owner->name }}</td>
                                <td class="align-middle">{{ $comment->news->title ?? 'NA' }}</td>
                                <td class="align-middle">{{ $comment->score }}</td>
                                <td class="align-middle">
                                    @if ($comment->status == 1)
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Banned</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex gap-2">
                                        @if ($comment->status == 1)
                                            <form action="{{ route('admin.comments.updateStatus', $comment->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to ban this comment?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="0">
                                                <button type="submit" class="btn btn-danger btn-sm">Ban</button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.comments.updateStatus', $comment->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to approve this comment?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="1">
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-center">
                {{ $comments->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div> --}}
        <!-- Comments Table -->
        <div class="card shadow-sm">

            <div class="card-body p-0 table-responsive">
                <table class="table table-hover  mb-0">
                    <thead class="">
                        <form action="{{route('admin.comment.search')}}">
                            <td colspan="5">
                                <input type="text" class="form-control px-4" style="border-radius: 2rem;"
                                    placeholder="Search..." name="q" value="{{ request()->q }}">
                            </td>
                            <td colspan="1" class="d-flex">
                                <button class="btn btn-success mr-1"><i class="fas fa-search"></i></button>
                                <a href="{{route('admin.comments.index')}}" class="btn btn-danger "><i class="fas fa-undo"></i></a>
                            </td>
                        </form>
                        <tr>
                            <th>ID</th>
                            <th>Comment</th>
                            <th>User</th>
                            <th>News</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $index => $comment)
                            <tr>
                                <td class="align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle">{{ Str::limit($comment->comment, 60, '...') }} </td>
                                <td class="align-middle">{{ $comment->owner->name }}</td>
                                <td class="align-middle">{{ $comment->news->title ?? 'NA' }}</td>
                                <td class="align-middle">{{ $comment->score }}</td>
                                <td class="align-middle">
                                    @if ($comment->status == 1)
                                        <span class="badge bg-success text-light">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Banned</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex gap-2">
                                        @if ($comment->status == 1)
                                            <form action="{{ route('admin.comments.updateStatus', $comment->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to ban this comment?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="0">
                                                <button type="submit" class="btn btn-danger btn-sm">Ban</button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.comments.updateStatus', $comment->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to approve this comment?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="1">
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-center">
                {{ $comments->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
