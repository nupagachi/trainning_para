<?php

namespace App\Listeners;

use App\Events\DBRealtime;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ListenDBRealtime
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
     * @param  DBRealtime  $event
     * @return void
     */
    public function handle(DBRealtime $event)
    {
        //
    }
}
