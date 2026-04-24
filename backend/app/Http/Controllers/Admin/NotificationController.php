<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::latest()->paginate(30);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function readAll()
    {
        AdminNotification::whereNull('read_at')
            ->where(function ($q) {
                $q->whereNull('user_id')->orWhere('user_id', auth()->id());
            })
            ->update(['read_at' => now()]);
        return back();
    }

    public function read(AdminNotification $notification)
    {
        $notification->update(['read_at' => now()]);
        return $notification->link ? redirect($notification->link) : back();
    }
}
