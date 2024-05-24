@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')

<form action="{{ route('admin.posts')}}" method="get">
    <input type="search" name="search" value="{{ $search }}" placeholder="search for posts" class="form-control form-control-sm mb-3 ms-auto" style="width:10rem">
</form>

<table class="table table-hover bg-white border align-middle text-secondary">
    <thead class="text-secondary small text-uppercase table-primary">
        <tr>
            <th></th>
            <th></th>
            <th>Category</th>
            <th>Owner</th>
            <th>Created at</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($all_posts as $post)
            <tr>
                <td class="text-center">{{ $post->id }}</td>
                <td>
                    <a href="{{ route('post.show', $post->id)}}">
                        <img src="{{ $post->image }}" alt="" class="image-lg d-block mx-auto">
                    </a>
                </td>
                <td>
                    @forelse($post->categoryPosts as $category_post)
                        <div class="badge bg-secondary bg-opacity-50">
                            {{ $category_post->category->name }}
                        </div>
                    @empty 
                        Uncategorized
                    @endforelse
                </td>
                <td>
                    <a href="{{ route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark">
                        {{ $post->user->name }}
                    </a>
                </td>
                <td>{{ $post->created_at }}</td>
                <td>
                    @if($post->trashed())
                        <i class="fa-solid fa-circle-minus"></i> Hidden
                    @else
                        <i class="fa-solid fa-circle text-primary"></i> Visible
                    @endif
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>

                        <div class="dropdown-menu">
                            @if(!$post->trashed())
                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post{{ $post->id }}">
                                    <i class="fa-solid fa-eye-slash"></i> Hide post {{ $post->id }}
                                </button>
                            @else 
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#unhide-post{{ $post->id }}">
                                    <i class="fa-solid fa-eye"></i> Unhide post {{ $post->id }}
                                </button>
                            @endif
                        </div>
                    </div>
                    @include('admin.posts.actions')
                </td>
            </tr>
        @empty 
            <tr>
                <td class="text-center" colspan="7">No posts found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $all_posts->links() }}
@endsection