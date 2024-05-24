<div class="modal fade" id="delete-post{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h4 class="h5 text-danger"><i class="fa-regular fa-trash-can"></i> Delete Post</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this post?</p>
                <img src="{{ $post->image }}" alt="" class="image-lg">
                <p class="text-muted mt-2">{{ $post->description }}</p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('post.destroy', $post->id)}}" method="post">
                    @csrf 
                    @method('DELETE')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-danger">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>