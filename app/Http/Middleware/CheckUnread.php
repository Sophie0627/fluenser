<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserInbox;
use App\Models\UserRequest;
use App\Models\UserTask;
use App\Models\User;

class CheckUnread
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
        if(isset(Auth::user()->id)) {
            $unread = UserInbox::where('user_id', '=', Auth::user()->id)
                    ->get();
            $unread->inbox = count($unread);
            
            $unreadrequests = UserRequest::where('user_id', '=', Auth::user()->id)
                    ->get();
            $unread->requests = count($unreadrequests);
    
            $unreadTask = UserTask::where('user_id', '=', Auth::user()->id)                ->get();
            $unread->task = count($unreadTask);
            $user = User::find(Auth::user()->id);
            $user->loggedIn = true;
            $user->save();
        } else {
            $unread = UserInbox::where('user_id', '=', 1)
                    ->get();
            $unread->inbox = 0;
            $unread->requests = 0;
            $unread->task = 0;
        }

        $request->attributes->add([
            'unread' => $unread,
        ]);

        return $next($request);
    }
}
