<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Events\CommentCreated;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'content' => 'required|max:1000',
        ]);

        $comment = $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);
        // notification
        if ($user->id !== $post->user_id) {
            Notification::create([
                'user_id' => $post->user_id,
                'sender_id' => $user->id,
                'message' => $user->name . 'commented your post',
                'type' => 'comment',
                'notifiable_type' => 'post',
                'notifiable_id' => $post->id,
            ]);
        }
        return response()->json([
            'comment' => $comment->load('user'),
            'comments_count' => $post->comments()->count()
        ]);
    }

    public function destroy(Comment $comment)
    {
        if (Auth::user()->id !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->json(['success' => true]);
    }
}
