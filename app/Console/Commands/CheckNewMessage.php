<?php

namespace App\Console\Commands;

use App\Events\Notify;
use App\Http\Controllers\NotificationController;
use App\Messages_ChatWork;
use App\New_Messages;
use Illuminate\Console\Command;
use Pusher\Pusher;

class CheckNewMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check new messages!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $notifi=new NotificationController();
        $chat=new \ChatWorkAPI();
        $get_data=$chat->callAPI('GET','https://api.chatwork.com/v2/rooms/155673778/messages?force=0',false);
        $response=json_decode($get_data,true);
        if($response!=null){
            foreach ($response as $resp){
                $member=['message_id'=>array_get($resp, 'message_id'),
               'name'=>array_get($resp,'account.name'),
               'avatar'=>array_get($resp,'account.avatar_image_url'),
               'send_time'=>date('Y-m-d H:i:s', array_get($resp, 'send_time')),
               'message'=>array_get($resp,'body')
               ];
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

        $pusher->trigger('Notify', 'real-time-new-message-db', false);
                Messages_ChatWork::create($member);
                New_Messages::create($member);
//                event(new Notify('vao day thanh cong ròi nay'));
            }
        }

    }
}
