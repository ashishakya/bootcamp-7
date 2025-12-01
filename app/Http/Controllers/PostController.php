<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::with('user')->orderByDesc('created_at')->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['is_published'] = $request->boolean('is_published');

        Post::create($data);

        return redirect()->route('posts.index')->with('status', 'Post created successfully.');
    }

    public function show(Post $post): View
    {
        $post->load(['user', 'comments']);

        return view('posts.show', compact('post'));
    }

    public function storeComment(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $post->comments()->create([
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('posts.show', $post)->with('status', 'Comment added successfully.');
    }

    public function edit(Post $post): View
    {
        return view('posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');

        $post->update($data);

        return redirect()->route('posts.index')->with('status', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Post deleted successfully.');
    }
}
