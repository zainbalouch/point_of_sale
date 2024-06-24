<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $user = Auth::user();
        $unreadNotification = $user->notifications()->where('id', $id)->first();

        $unreadNotification->markAsRead();
        
        // Redirect to the link associated with the notification
        return redirect()->to($unreadNotification->data['link']);
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications()->update(['read_at' => now()]);
        
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

}
