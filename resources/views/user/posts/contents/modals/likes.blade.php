<div class="modal fade" id="likes-post{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button data-bs-dismiss="modal" class="btn ms-auto text-primary fw-bold">x</button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-8">
                        @foreach($post->likes as $like)
                            <div class="row mb-3">
                                <div class="col-auto">
                                    {{-- avatar/icon --}}
                                    @if($like->user->avatar)
                                        <img src="{{ $like->user->avatar }}" alt="" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                    @endif 
                                </div>
                                <div class="col ps-0 text-truncate">
                                    {{-- user name --}}
                                    <a href="{{ route('profile.show', $like->user_id)}}" class="text-decoration-none text-dark fw-bold">{{ $like->user->name }}</a>
                                </div>
                                <div class="col-auto">
                                    @if($like->user_id != Auth::user()->id)
                                        @if($like->user->isFollowed())
                                            <form action="{{ route('follow.destroy', $like->user_id)}}" method="post">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="bg-transparent p-0 shadow-none border-0 text-secondary">Unfollow</button>
                                            </form>
                                        @else
                                            <form action="{{ route('follow.store', $like->user_id)}}" method="post">
                                                @csrf 
                                                <button type="submit" class="bg-transparent p-0 shadow-none border-0 text-primary">Follow</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>