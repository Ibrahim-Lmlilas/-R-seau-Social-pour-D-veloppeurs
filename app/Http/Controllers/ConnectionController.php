<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Connection;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function sendConnectionRequest(User $user)
    {
        $loggedInUser = Auth::user();

        $existingConnection = Connection::where(function ($query) use ($loggedInUser, $user) {
            $query->where('user_id', $loggedInUser->id)
                  ->where('connection_id', $user->id);
        })->orWhere(function ($query) use ($loggedInUser, $user) {
            $query->where('user_id', $user->id)
                  ->where('connection_id', $loggedInUser->id);
        })->first();

        if ($existingConnection) {
            return back()->with('error', 'Connection request already sent or you are already connected.');
        }

        $connection = new Connection();
        $connection->user_id = $loggedInUser->id;
        $connection->connection_id = $user->id;
        $connection->status = 'pending';
        $connection->save();

        return back()->with('success', 'Connection request sent.');
    }

    public function acceptConnectionRequest(User $user)
    {
        $loggedInUser = Auth::user();

        $connection = Connection::where('user_id', $user->id)
                            ->where('connection_id', $loggedInUser->id)
                            ->where('status', 'pending')
                            ->first();

        if (!$connection) {
            return back()->with('error', 'No pending connection request found.');
        }

        $connection->status = 'accepted';
        $connection->save();

        return back()->with('success', 'Connection request accepted.');
    }

    public function rejectConnectionRequest(User $user)
    {
        $loggedInUser = Auth::user();

        $connection = Connection::where('user_id', $user->id)
                            ->where('connection_id', $loggedInUser->id)
                            ->where('status', 'pending')
                            ->first();

        if (!$connection) {
            return back()->with('error', 'No pending connection request found.');
        }

        $connection->status = 'rejected';
        $connection->save();

        return back()->with('success', 'Connection request rejected.');
    }



    public function getConnections()
    {
        $loggedInUser = Auth::user();
        $userss = User::where('id', '!=', Auth::id())->get();
        $user = $loggedInUser;

        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->get();
        $postCount = $posts->count(); // Count the posts
        $pendingRequests = Connection::where('connection_id', $loggedInUser->id)
                                     ->where('status', 'pending')
                                     ->get();
        $sentRequests = Connection::where('user_id', $loggedInUser->id)
                                     ->get();
        $posts = Post::where('user_id', $loggedInUser->id)->get();
        $postCount = $posts->count();

        return view('connections.index', compact('userss', 'user', 'pendingRequests', 'sentRequests', 'postCount'));
    }
}
