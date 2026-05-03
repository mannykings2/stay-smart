@extends('layouts.app', ['activePage' => 'Blog Management'])

@section('content')
    <main class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-header border-0 p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Blog Management</h5>
                            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary rounded-3">
                                <i class="bi bi-plus-circle me-1"></i> Create Post
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Author</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($posts as $post)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($post->image_path)
                                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image"
                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $post->title }}</td>
                                            <td>
                                                @if($post->is_published)
                                                    <span class="badge bg-success">Published</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Draft</span>
                                                @endif
                                            </td>
                                            <td>{{ $post->user->first_name ?? 'Unknown' }}</td>
                                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.blog.edit', $post->id) }}"
                                                        class="btn btn-sm btn-info text-white">
                                                        <i class="bi bi-pencil-fill"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST"
                                                        class="confirm-submit" data-message="Are you sure you want to delete this blog post?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash-fill"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No blog posts found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection