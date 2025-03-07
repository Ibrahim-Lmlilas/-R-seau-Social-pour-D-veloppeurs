<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewNotification;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $notifications = Auth::user()->notifications()
                ->orderBy('created_at', 'desc')
                ->paginate(10);



            return view('notifications.index', compact('notifications'));
        } catch (\Exception $e) {

            Log::error("message");('Notification error: ' . $e->getMessage());
            return view('notifications.index', ['notifications' => collect()]);
        }
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

    // Add this method to create and broadcast a notification
    public function createNotification($userId, $senderId, $message, $type, $notifiableType, $notifiableId)
    {
        $notification = Notification::create([
            'user_id' => $userId,
            'sender_id' => $senderId,
            'message' => $message,
            'type' => $type,
            'notifiable_type' => $notifiableType,
            'notifiable_id' => $notifiableId,
        ]);

        // Broadcast the notification
        event(new NewNotification($notification));

        return $notification;
    }
}
