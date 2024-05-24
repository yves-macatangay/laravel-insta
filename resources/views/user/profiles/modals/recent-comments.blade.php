<style>
    .modal-body {
        overflow-y:scroll;
        max-height:350px;
    }
</style>
<div class="modal fade" id="recent-comments">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">
            <div class="modal-header border-secondary">
                <h4 class="h5 text-secondary">Recent Comments</h4>
            </div>
            <div class="modal-body">
                @forelse($user->comments->take(5) as $comment)
                    <div class="border rounded-3 border-primary mb-2 py-2 px-3 text-secondary">
                        <p>{{ $comment->body }}</p>
                        <hr class="d-block">
                        <span class="small">Replied to <a href="{{ route('post.show', $comment->post_id)}}" class="text-decoration-none">{{ $comment->post->user->name }}'s post</a></span>
                    </div>
                @empty 
                    <p class="text-muted text-center">No recent comments.</p>
                @endforelse
            </div>
            <div class="modal-footer border-0">
                <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-secondary">Close</button>
            </div>
        </div>
    </div>
</div>