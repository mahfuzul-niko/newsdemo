@extends('layouts.admin')

@section('content')
    <div class="">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">News Management</h1>
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
                            <form action="{{ route('admin.news.index') }}">
                                <td colspan="2">
                                    <input type="text" class="form-control px-4" style="border-radius: 2rem;"
                                        placeholder="Search..." name="q" value="{{ request()->q }}">
                                </td>
                                <td colspan="1" class="d-flex">
                                    <button class="btn btn-success mr-1"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('admin.news.index') }}" class="btn btn-danger "><i
                                            class="fas fa-undo"></i></a>
                                </td>
                            </form>
                        </tr>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Views Count</th>
                            <th scope="col">Display Count</th>
                            <th scope="col">Click Through Rate</th>
                            <th scope="col">Comment count</th>
                            <th scope="col">Shares</th>
                            <th scope="col">Likes</th>
                            <th>
                                Status
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allnews as $news)
                            <tr>
                                <td class="align-middle">{{ Str::limit($news->title, 25, '...') }}</td>
                                <td class="align-middle">{{ $news->view_count }}</td>
                                <td class="align-middle">{{ $news->display_count }}</td>
                                <td class="align-middle">
                                    {{ $news->display_count ? number_format(($news->view_count / $news->display_count) * 100, 2) : 0 }}
                                    %</td>
                                <td class="align-middle">{{ $news->comments_count }}</td>
                                <td class="align-middle">{{ $news->shares }}</td>
                                <td class="align-middle">{{ $news->savedBy->count() }}</td>
                                <td class="align-middle">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox"
                                            onchange="activeNews('{{ $news->id }}')"
                                            @if ($news->status) checked @endif role="switch"
                                            id="news{{ $news->id }}">
                                        <label class="form-check-label" for="news{{ $news->id }}">Set as active</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox"
                                            onchange="imageStatus('{{ $news->id }}')"
                                            @if ($news->image_status) checked @endif role="switch"
                                            id="news_image{{ $news->id }}">
                                        <label class="form-check-label" for="news_image{{ $news->id }}">Enable
                                            image</label>
                                    </div>

                                </td>
                                <td class="align-middle">
                                    <div class="d-flex ">
                                        <a href="{{ route('admin.news.show', $news) }}"
                                            class="btn btn-sm btn-success">View</a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-center">
                {{ $allnews->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function activeNews(id) {
            fetch("{{ route('admin.news.status') }}?id=" + id)
        }

        function imageStatus(id) {
            fetch("{{ route('admin.image.status') }}?id=" + id)
        }
    </script>
@endsection
