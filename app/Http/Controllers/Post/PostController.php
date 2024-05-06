<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);

        return view('post.home', [
            'title' => 'Home | DanBlog',
            'posts' => $posts,
        ]);
    }

    public function show(string $slug)
    {
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
        if (empty($slug)) {
            abort(404);
        }

        $post = Post::with('comments.user')->where('slug', $slug)->first();
        if (!$post) {
            abort(404);
        }
        
        $comments = Comment::orderBy('created_at', 'desc')->where('post_id', $post->id)->paginate(10);
    
        return view('post.show', [
            'title' => $post->title,
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function search(Request $request)
    {
        $searchTerm = preg_replace('/[^A-Za-z0-9 ]/', '', $request->input('q'));

        if (empty($searchTerm)) {
            return redirect()->route('home');
        }

        $posts = Post::with('user')
                    ->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('content', 'like', '%' . $searchTerm . '%')
                    ->orderByDesc('created_at')
                    ->paginate(12)
                    ->appends(['q' => $searchTerm]);

        $latestPosts = [];
        if ($posts->isEmpty()) {
            $latestPosts = Post::with('user')
                ->orderByDesc('created_at')
                ->take(3)
                ->get();
        }

        return view('post.search', [
            'title' => 'Busca do DanBlog',
            'posts' => $posts,
            'latestPosts' => $latestPosts,
            'searchTerm' => $searchTerm
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'content' => 'required|string',
        ]);

        $post = new Post();
        $post->user_id = $request->user()->id;
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->content = $request->content;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails');
            $post->thumbnail = $thumbnailPath;
        }

        $post->save();

        return redirect()->route('home')->with('success', 'Postagem criada com sucesso.');
    }

    public function update(Request $request, Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return redirect()->route('home');
        }

        $request->validate([
            'title' => 'required|string',
            'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
            'content' => 'required|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            if (!empty($post->avatar)) {
                $oldThumbnailPath = public_path('storage/' . $post->thumbnail);

                if (file_exists($oldThumbnailPath)) {
                    unlink($oldThumbnailPath);
                }
            }

            $thumbnailPath = $request->file('thumbnail')->store('thumbnails');

            $post->thumbnail = $thumbnailPath;
        }

        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->content = $request->content;
        $post->save();

        return redirect()->route('posts.show', ['slug' => $post->slug]);
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return redirect()->route('home');
        }

        $post->delete();

        return redirect()->route('home');
    }
}
