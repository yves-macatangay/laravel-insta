@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
{{-- add --}}
<form action="{{ route('admin.categories.store')}}" method="post" class="row mb-4 gx-2">
    @csrf 
    <div class="col-4">
        <input type="text" name="name" value="{{ old('name')}}" placeholder="Add a category..." class="form-control">
        @error('name')
        <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Add
        </button>
    </div>
</form>

{{-- list --}}
<table class="table table-sm table-hover bg-white text-center text-secondary border">
    <thead class="table-danger text-secondary text-uppercase">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Count</th>
            <th>Last Updated</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($all_categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td class="text-dark">{{ $category->name }}</td>
            <td>{{ $category->categoryPosts->count() }}</td>
            <td>{{ $category->updated_at }}</td>
            <td>
                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#edit-category{{ $category->id }}">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-category{{ $category->id }}">
                    <i class="fa-solid fa-trash-can"></i>
                </button>

                @include('admin.categories.actions')
            </td>
        </tr>
        @empty 
        <tr>
            <td colspan="5">No categories found.</td>
        </tr>
        @endforelse
        <tr>
            <td>0</td>
            <td>
                Uncategorized
                <p class="xsmall mb-0">Does not include hidden posts</p>
            </td>
            <td>
                {{ $uncategorized_count }}
            </td>
        </tr>
    </tbody>
</table>
{{ $all_categories->links() }}
@endsection

