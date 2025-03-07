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

        $existingLike = Like::where('user_id', $user->id)
                            ->where('post_id', $post->id)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            // Create a new like
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id
            ]);
            $liked = true;

            if ($user->id !== $post->user_id) {
                app(NotificationController::class)->createNotification(
                    $post->user_id,
                    $user->id,
                    $user->name . ' liked your post',
                    'like',
                    'post',
                    $post->id
                );
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
