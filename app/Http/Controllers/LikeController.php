<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request, Post $post)
    {
        $user = Auth::user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->where('user_id', $user->id)->delete();
        } else {
            $post->likes()->create([
                'user_id' => $user->id,
            ]);
        }

        return back();
    }
}
