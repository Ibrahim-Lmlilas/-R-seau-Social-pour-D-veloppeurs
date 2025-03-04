<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->with(['sender', 'notifiable'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }


    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->is_read = true;
        $notification->read_at = now();
        $notification->save();

        return redirect()->back()->with('success', 'Notification marked as read');
    }


    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return redirect()->back()->with('success', 'All notifications marked as read');
    }


    public function destroy(Notification $notification)
    {
        // Check if the notification belongs to the current user
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted');
    }


    public function unreadCount()
    {
        $count = Auth::user()->notifications()->where('is_read', false)->count();

        return response()->json(['count' => $count]);
    }
}
