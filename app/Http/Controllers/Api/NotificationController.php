<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(){
        $notifications = request()->user()->notifications()->orderBy('created_at','desc')->paginate(10);
        return $this->success('Got Notifications',$notifications);
    }

    public function update(Request $request,$id){
        /** @var DatabaseNotification $notification */
        $notification = $request->user()->notifications()->where('id','=',$id)->first();
        $notification->markAsRead();
        return $this->success('Marked as Read!');
    }

    public function markAllAsRead(Request $request){
        $request->user()->unreadNotifications->markAsRead();
        return $this->success('Marked all notifications as read!');
    }
}
