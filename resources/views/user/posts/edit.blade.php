@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
    @csrf 
    @method('PATCH')

    <p class="fw-bold">Category <span class="fw-light">(up to 3)</span></p>
    <div>
        @foreach($all_categories as $category)
            <div class="form-check form-check-inline">
                @if(in_array($category->id, $selected_categories))
                    {{-- checked box --}}
                    <input type="checkbox" name="category_id[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input" checked>
                @else
                    <input type="checkbox" name="category_id[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input">
                @endif
                <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
            </div>
        @endforeach
    </div>
    @error('category_id')
        <div class="text-danger small">{{ $message }}</div>
    @enderror

    <label for="description" class="form-label fw-bold mt-3">Description</label>
    <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{ old('description', $post->description) }}</textarea>
    @error('description')
        <div class="text-danger small">{{ $message }}</div>
    @enderror

    <label for="image" class="form-label fw-bold mt-3">Image</label>
    <div class="w-50">
        <img src="{{ $post->image }}" alt="" class="img-thumbnail mb-1">
        <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
        <p class="form-text" id="image-info">
            Acceptable formats: jpeg, jpg, png, gif only <br>
            Max size is 1048 KB
        </p>
    </div>
    
    @error('image')
        <div class="text-danger small">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-warning mt-4 px-4">Save</button>
</form>


@endsection