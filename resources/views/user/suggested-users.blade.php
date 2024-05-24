@extends('layouts.app')

@section('title', 'Suggested Users')

@section('content')
    
  <div class="row justify-content-center">
    <div class="col-4">
        <h2 class="h4 mb-4">Suggested</h2>
        @forelse($suggested_users as $user)
            <div class="row mb-3 align-items-center">
                <div class="col-auto">
                    {{-- avatar --}}
                    <a href="{{ route('profile.show', $user->id)}}">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-md">
                        @else 
                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                        @endif
                    </a>
                </div>
                <div class="col ps-0 text-truncate">
                    {{-- name/email --}}
                    <a href="{{ route('profile.show', $user->id)}}" class="text-decoration-none fw-bold text-dark">
                        {{ $user->name }}
                    </a>
                    <p class="mb-0 text-muted small">{{ $user->email }}</p>

                    {{-- label --}}
                    <span class="text-muted small">
                        @if($user->followsYou())
                            Follows you
                        @else 
                            @if($user->followers->count() == 0)
                                No followers yet
                            @elseif($user->followers->count() ==1)
                                1 follower 
                            @else 
                                {{ $user->followers->count() }} followers
                            @endif
                        @endif
                    </span>
                </div>
                <div class="col-auto">
                    {{-- follow --}}
                    <form action="{{ route('follow.store', $user->id)}}" method="post">
                        @csrf 
                        <button type="submit" class="bg-transparent border-0 shadow-none p-0 text-primary">Follow</button>
                    </form>
                </div>
            </div>
        @empty 
            <p class="h5 text-muted text-center">No suggested users.</p>
        @endforelse
    </div>
  </div>
  
@endsection 