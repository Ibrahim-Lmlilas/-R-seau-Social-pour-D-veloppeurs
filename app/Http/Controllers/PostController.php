<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $posts = Post::all();
        return view('dashboard', compact('posts', 'user'));
    }

    public function createLine(): View
    {
        return view('posts.create_line');
    }

    public function createCode(): View
    {
        return view('posts.create_code');
    }

    public function createImage(): View
    {
        return view('posts.create_image');
    }

    public function storeLine(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'line' => 'required',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->type = 'line';
        $post->line = $request->line;
        $post->hashtags = $request->hashtags;
        $post->save();

        return redirect()->route('dashboard');
    }

    public function storeCode(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'code' => 'required',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->type = 'code';
        $post->code = $request->code;
        $post->hashtags = $request->hashtags;
        $post->save();

        return redirect()->route('dashboard');
    }

    public function storeImage(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('posts', 'public');

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->type = 'image';
        $post->image = $imagePath;
        $post->content = $imagePath;
        $post->hashtags = $request->hashtags;
        $post->save();

        return redirect()->route('dashboard');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::user()->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::user()->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'hashtags' => 'nullable',
            'type' => 'required|in:line,code,image',
            'line' => 'nullable|required_if:type,line',
            'code' => 'nullable|required_if:type,code',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->type === 'image' && !$request->hasFile('image') && !$post->image) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        }

        $post->title = $request->title;
        $post->description = $request->description;
        $post->hashtags = $request->hashtags;
        $post->type = $request->type;

        if ($request->type === 'line') {
            $post->line = $request->line;
            $post->code = null;
            $post->image = null;
        } elseif ($request->type === 'code') {
            $post->code = $request->code;
            $post->line = null;
            $post->image = null;
        } elseif ($request->type === 'image') {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('posts', 'public');
                $post->image = $imagePath;
            }
            $post->line = null;
            $post->code = null;
        }

        $post->save();

        return redirect()->route('posts.myPosts')->with('success', 'Post updated successfully.');
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::user()->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $post->delete();

        return redirect()->route('posts.myPosts')->with('success', 'Post deleted successfully.');
    }

    public function myPosts(): View
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(20);
        $postCount = $posts->total(); // Count the posts
        return view('posts.my_posts', compact('posts', 'user', 'postCount')); // Pass $user and $postCount to the view
    }
}
