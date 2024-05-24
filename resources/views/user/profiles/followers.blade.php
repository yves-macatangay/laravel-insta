@extends('layouts.app')

@section('title', $user->name . " - Followers")

@section('content')
  @include('user.profiles.header')

  @if($user->followers->isNotEmpty())
    <h4 class="h5 text-secondary text-center">Followers</h4>
    <div class="row justify-content-center">
        <div class="col-4">
            @foreach($user->followers as $follower)
                <div class="row mb-3 align-items-center">
                    <div class="col-auto">
                        {{-- follower avatar --}}
                        <a href="{{ route('profile.show', $follower->follower->id)}}">
                            @if($follower->follower->avatar)
                                <img src="{{ $follower->follower->avatar }}" alt="" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        {{-- follower name --}}
                        <a href="{{ route('profile.show', $follower->follower->id)}}" class="text-decoration-none fw-bold text-dark">
                            {{ $follower->follower->name }}
                        </a>
                    </div>
                    <div class="col-auto">
                        @if($follower->follower_id != Auth::user()->id)
                            @if($follower->follower->isFollowed())
                                {{-- unfollow --}}
                                <form action="{{ route('follow.destroy', $follower->follower_id)}}" method="post">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="bg-transparent shadow-none border-0 p-0 text-secondary">Following</button>
                                </form>
                            @else 
                                {{-- follow --}}
                                <form action="{{ route('follow.store', $follower->follower_id)}}" method="post">
                                    @csrf 
                                    <button type="submit" class="bg-transparent shadow-none border-0 p-0 text-primary">Follow</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

  @else 
    <h4 class="h5 text-secondary text-center">No followers yet.</h4>
  @endif

@endsection