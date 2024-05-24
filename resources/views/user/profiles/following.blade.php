@extends('layouts.app')

@section('title', $user->name . " - Following")

@section('content')
  @include('user.profiles.header')

  @if($user->follows->isNotEmpty())
    <h4 class="h5 text-secondary text-center">Following</h4>
    <div class="row justify-content-center">
        <div class="col-4">
            @foreach($user->follows as $follow)
                <div class="row mb-3 align-items-center">
                    <div class="col-auto">
                        {{-- follower avatar --}}
                        <a href="{{ route('profile.show', $follow->user->id)}}">
                            @if($follow->user->avatar)
                                <img src="{{ $follow->user->avatar }}" alt="" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        {{-- follower name --}}
                        <a href="{{ route('profile.show', $follow->user->id)}}" class="text-decoration-none fw-bold text-dark">
                            {{ $follow->user->name }}
                        </a>
                    </div>
                    <div class="col-auto">
                        @if($follow->followed_id != Auth::user()->id)
                            @if($follow->user->isFollowed())
                                {{-- unfollow --}}
                                <form action="{{ route('follow.destroy', $follow->followed_id)}}" method="post">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="bg-transparent shadow-none border-0 p-0 text-secondary">Following</button>
                                </form>
                            @else 
                                {{-- follow --}}
                                <form action="{{ route('follow.store', $follow->followed_id)}}" method="post">
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
    <h4 class="h5 text-secondary text-center">Not following anyone yet.</h4>
  @endif

@endsection