@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
<form action="{{ route('post.store')}}" method="post" enctype="multipart/form-data">
    @csrf 

    <p class="fw-bold mb-1">Category <span class="fw-light">(up to 3)</span></p>
    <div>
        @forelse($all_categories as $category)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="categories[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input">
                <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
            </div>
        @empty 
            <p class="text-muted">No categories found. Please add categories first.</p>
        @endforelse
    </div>
    @error('categories')
    <p class="mb-0 text-danger small">{{ $message }}</p>
    @enderror

    <label for="description" class="form-label fw-bold mt-3">Description</label>
    <textarea name="description" id="description" class="form-control" placeholder="What's on your mind" rows="3">{{ old('description') }}</textarea>
     @error('description')
    <p class="mb-0 text-danger small">{{ $message }}</p>
    @enderror

    <label for="image" class="form-label fw-bold mt-3">Image</label>
    <input type="file" name="image" id="image" class="form-control">
    <p class="form-text">
        Acceptable formats: jpeg, jpg, png, gif only <br>
        Max size is 1048 KB 
    </p>
     @error('image')
    <p class="mb-0 text-danger small">{{ $message }}</p>
    @enderror

    <button type="submit" class="btn btn-primary mt-4 px-4">Post</button>
</form>

@endsection