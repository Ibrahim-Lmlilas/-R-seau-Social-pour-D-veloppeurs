<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\NewChatMessage;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $connections = Connection::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('connected_user_id', $user->id);
            })
            ->where('status', 'accepted')
            ->get();

        $connectionUserIds = [];
        foreach ($connections as $connection) {
            if ($connection->user_id == $user->id) {
                $connectionUserIds[] = $connection->connected_user_id;
            } else {
                $connectionUserIds[] = $connection->user_id;
            }
        }

        $connectionUsers = User::whereIn('id', $connectionUserIds)->get();

        $receiverId = request('user_id');
        $receiver = null;

        if ($receiverId && in_array($receiverId, $connectionUserIds)) {
            $receiver = User::find($receiverId);

            Message::where('user_id', $receiverId)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $messages = Message::where(function($query) use ($user, $receiverId) {
                    $query->where('user_id', $user->id)
                        ->where('receiver_id', $receiverId);
                })
                ->orWhere(function($query) use ($user, $receiverId) {
                    $query->where('user_id', $receiverId)
                        ->where('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $messages = collect();
        }

        $unreadCounts = [];
        foreach ($connectionUserIds as $connectionId) {
            $count = Message::where('user_id', $connectionId)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();
            $unreadCounts[$connectionId] = $count;
        }

        return view('chat.index', compact('connectionUsers', 'messages', 'receiver', 'unreadCounts'));
    }


    //  broadcasting
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $user = Auth::user();

        // Check  connection
        $isConnection = Connection::where(function($query) use ($user, $request) {
                $query->where('user_id', $user->id)
                    ->where('connected_user_id', $request->receiver_id);
            })
            ->orWhere(function($query) use ($user, $request) {
                $query->where('user_id', $request->receiver_id)
                    ->where('connected_user_id', $user->id);
            })
            ->where('status', 'accepted')
            ->exists();

        if (!$isConnection) {
            return response()->json(['error' => 'You can only send messages to your connections'], 403);
        }

        $message = Message::create([
            'user_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        // Broadcast the new message event to the receiver
        event(new NewChatMessage($message));

        // Format the response for the frontend
        return response()->json([
            'id' => $message->id,
            'message' => $message->message,
            'created_at' => $message->created_at->format('H:i'),
            'user_id' => $user->id,
            'user_name' => $user->name,
            'is_read' => false
        ]);
    }


    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        $message->load('user');

        event(new NewChatMessage($message));

        return response()->json($message);
    }

    public function markAsRead($messageId)
    {
        $message = Message::findOrFail($messageId);

        if ($message->receiver_id == Auth::id()) {
            $message->is_read = true;
            $message->save();
        }

        return response()->json(['success' => true]);
    }
}
