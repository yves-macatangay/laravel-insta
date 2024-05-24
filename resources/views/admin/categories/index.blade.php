@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')

<form action="{{ route('admin.categories.store')}}" method="post" class="row gx-2 mb-4">
    @csrf 
    <div class="col-4">
        <input type="text" name="name" class="form-control" placeholder="Add a category...">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
    </div>
</form>

<table class="table table-hover table-sm bg-white border text-secondary text-center align-middle">
    <thead class="table-warning small text-uppercase text-secondary">
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
                    {{-- edit --}}
                    <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#edit-categ{{ $category->id }}">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    {{-- delete --}}
                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-categ{{ $category->id }}">
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
            <td>Uncategorized</td>
            <td>{{ $uncategorized_count }}</td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>

@endsection