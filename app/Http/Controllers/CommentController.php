<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id)
    {
        $request->validate([
            'comment' => 'required | min:1 | max:150'
        ]);

        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;
        $this->comment->body = $request->comment;
        $this->comment->save();

        return back();
    }

    public function destroy($id)
    {
        $this->comment->destroy($id);

        return back();
    }

    public function update(Request $request, $comment_id)
    {
        $request->validate([
            'edit_comment' => 'required | min:1 | max:150'
        ]);

        $comment = $this->comment->findOrFail($comment_id);

        $comment->body = $request->edit_comment;
        $comment->save();

        return redirect()->back();
    }
}
