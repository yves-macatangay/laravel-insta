<div class="mb-2">
    <a href="{{ route('profile.show', $comment->user->id)}}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
    &nbsp;
    <span class="fw-light">{{ $comment->body }}</span>
    <div class="text-muted small">
        {{ date("D, M d Y", strtotime($comment->created_at)) }}

         @if($comment->user->id == Auth::user()->id)
            <form action="{{ route('comment.destroy', $comment->id)}}" method="post" class="d-inline">
                @csrf 
                @method('DELETE')
                &middot;
                <button type="submit" class="bg-transparent border-0 shadow-none p-0 text-danger">Delete</button>
            </form>
        @endif
    </div>
</div>