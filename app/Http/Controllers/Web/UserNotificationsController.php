<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserNotificationsController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $notifications = Auth::user()->unreadNotifications;

        return NotificationResource::collection($notifications);
    }

    /**
     * @return void
     */
    public function markNotificationAsRead(Request $request, $notification)
    {
        $notification = $request->user()->notifications()->where('id', $notification)->first();

        if ($notification) {
            $notification->markAsRead();
        }
    }

    /**
     * @return void
     */
    public function markAllNotificationsAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
    }
}
