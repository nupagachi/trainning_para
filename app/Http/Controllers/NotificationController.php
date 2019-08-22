<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;

class NotificationController extends Controller
{

    public function EventNotification(){
        ;
    }
    public function index(){
        return view('admin.notification.index');
    }
    public function send(){
        return view('send');
    }
    public function sendMessage(Request $request){
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $data['title'] = $request->input('title');
        $data['content'] = $request->input('content');

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $pusher->trigger('Notify', 'real-time-new-message-db', $data);

        return redirect()->route('send');
    }
}
