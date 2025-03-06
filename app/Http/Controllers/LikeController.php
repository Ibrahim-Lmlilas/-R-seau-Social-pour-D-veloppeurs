<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $user = Auth::user();

        // Check if the user has already liked the post
        $existingLike = Like::where('user_id', $user->id)
                            ->where('post_id', $post->id)
                            ->first();

        if ($existingLike) {
            // Remove the like if it already exists
            $existingLike->delete();
            $liked = false;
        } else {
            // Create a new like
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id
            ]);
            $liked = true;

            // notification
            if ($user->id !== $post->user_id) {
                Notification::create([
                    'user_id' => $post->user_id,
                    'sender_id' => $user->id,
                    'message' => $user->name . ' liked your post',
                    'type' => 'like',
                    'notifiable_type' => 'post',
                    'notifiable_id' => $post->id,
                ]);
            }
        }

        return response()->json([
            'likes_count' => Like::where('post_id', $post->id)->count(),
            'liked' => $liked
        ]);
    }

    public function checkLike(Post $post)
    {
        $user = Auth::user();
        $liked = $post->likes()->where('user_id', $user->id)->exists();

        return response()->json([
            'liked' => $liked
        ]);
    }
}
