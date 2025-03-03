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

    /**
     * Mark a notification as read.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead(Notification $notification)
    {
        // Check if the notification belongs to the current user
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->is_read = true;
        $notification->read_at = now();
        $notification->save();

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return redirect()->back()->with('success', 'All notifications marked as read');
    }

    /**
     * Delete a notification.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Notification $notification)
    {
        // Check if the notification belongs to the current user
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted');
    }

    /**
     * Get unread notifications count.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unreadCount()
    {
        $count = Auth::user()->notifications()->where('is_read', false)->count();

        return response()->json(['count' => $count]);
    }
}
