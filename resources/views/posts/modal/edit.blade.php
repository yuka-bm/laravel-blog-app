<div class="modal fade" id="edit-comment-{{ $comment->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Comment</h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('comment.update', $comment->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <textarea name="edit_comment" id="edit_comment" rows="10" class="form-control mb-3" min="1" max="150" required>{{ old('comment', $comment->body) }}</textarea>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-secondary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>