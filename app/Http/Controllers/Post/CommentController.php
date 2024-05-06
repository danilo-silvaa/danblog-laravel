<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $post_id = $request->post_id;
        $comments = Comment::with('user')
                            ->where('post_id', $post_id)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return response()->json($comments);
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->user_id = $request->user()->id;
        $comment->post_id = $post->id;
        $comment->comment = $request->input('comment');
        $comment->save();

        return redirect()->route('posts.show', ['slug' => $post->slug])->with('success', 'Comentário adicionado com sucesso.');
    }
}