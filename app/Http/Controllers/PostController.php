<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Services\PostService;

class PostController extends Controller
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(): View
    {
        $user = Auth::user();
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
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
        $this->postService->createLinePost($request);

        return redirect()->route('dashboard');
    }

    public function storeCode(Request $request)
    {
        $this->postService->createCodePost($request);

        return redirect()->route('dashboard');
    }

    public function storeImage(Request $request)
    {
        $this->postService->createImagePost($request);

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

        $this->postService->updatePost($request, $post);

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
        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);
        $postCount = $posts->total(); // Count the posts
        return view('posts.my_posts', compact('posts', 'user', 'postCount')); // Pass $user and $postCount to the view
    }
}
