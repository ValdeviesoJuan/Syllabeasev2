<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markNotificationsAsRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
    
        return response()->json(['success' => true]);
    }
    
}
