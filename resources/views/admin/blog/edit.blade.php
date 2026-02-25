@extends('layouts.app', ['activePage' => 'Blog Management'])

@section('content')
    <main class="page-content">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card rounded-4">
                    <div class="card-header border-0 p-4">
                        <h5 class="mb-0">Edit Blog Post</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.blog.update', $blogPost->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Post Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $blogPost->title) }}" required>
                                @error('title')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Excerpt / Short Description</label>
                                <textarea class="form-control" id="excerpt" name="excerpt"
                                    rows="3">{{ old('excerpt', $blogPost->excerpt) }}</textarea>
                                <div class="form-text">A small summary displayed on the card.</div>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="content" name="content" rows="10"
                                    required>{{ old('content', $blogPost->content) }}</textarea>
                                @error('content')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Cover Image</label>
                                @if($blogPost->image_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $blogPost->image_path) }}" alt="Current Image"
                                            class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Leave empty to keep current image.</div>
                                @error('image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_published"
                                    name="is_published" value="1" {{ old('is_published', $blogPost->is_published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">Publish Status</label>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection