<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckForNotifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $notify_id = $request->query('notify_id');
        if ($notify_id) {
            $user = $request->user(); // Auth::user();
            
            // Mark all user's notifications as read
            //$user->notifications->markAsRead();

            $notification = $user->notifications()->find($notify_id);
            if ($notification && $notification->unread()) {
                $notification->markAsRead();
            }
        }

        return $next($request);
    }
}
