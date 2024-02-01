@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
    <table class="table table-hover text-secondary align-middle bg-white border">
        <thead class="text-secondary table-primary text-uppercase small">
            <tr>
                <th></th>
                <th></th>
                <th>Category</th>
                <th>Owner</th>
                <th>Created At</th>
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
                            <img src="{{ $post->image }}" alt="" class="img-lg d-block mx-auto">
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
                            <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>

                            @if(!$post->trashed())
                            <div class="dropdown-menu">
                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post{{ $post->id }}">
                                    <i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}
                                </button>
                            </div>
                            @else
                            <div class="dropdown-menu">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#unhide-post{{ $post->id }}">
                                    <i class="fa-solid fa-eye"></i> Unhide Post {{ $post->id }}
                                </button>
                            </div>
                            @endif
                        </div>
                        @include('admin.posts.status')
                    </td>
                </tr>
            @empty 
                <tr>
                    <td class="text-center">No posts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $all_posts->links() }}
@endsection