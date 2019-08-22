<?php

namespace App\Listeners;

use App\Events\Notify;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Pusher\Pusher;

class ListenNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Notify  $event
     * @return void
     */

    public function handle(Notify $event)
    {
//        $pusher=new Pusher();
//        $options = array(
//            'cluster' => 'ap1',
//            'encrypted' => true
//        );
//
//        $pusher = new Pusher(
//            env('PUSHER_APP_KEY'),
//            env('PUSHER_APP_SECRET'),
//            env('PUSHER_APP_ID'),
//            $options
//        );
//        $pusher->trigger('Notify','real-time-new-message-db',$event->message);
    }
}
