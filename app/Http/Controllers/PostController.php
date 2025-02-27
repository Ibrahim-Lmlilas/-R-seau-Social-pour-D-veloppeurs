<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{

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
        $post->save();

        return redirect()->route('dashboard');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
