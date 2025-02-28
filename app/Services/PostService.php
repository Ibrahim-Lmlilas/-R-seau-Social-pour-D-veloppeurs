<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function createLinePost(Request $request): Post
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

        return $post;
    }

    public function createCodePost(Request $request): Post
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

        return $post;
    }

    public function createImagePost(Request $request): Post
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

        return $post;
    }

    public function updatePost(Request $request, Post $post): Post
    {
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

        return $post;
    }
}
