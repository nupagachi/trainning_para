<?php

namespace App\Http\Controllers;


use App\Events\Notify;
use App\Messages_ChatWork;
use App\User;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Pusher\Pusher;


class ChatWorkController extends Controller
{
    //api db
    public $chat;
    public function __construct(\ChatWorkAPI $chat)
    {
        $this->chat=$chat;
    }

    public function getDataAPI()
    {
        $get_data = $this->chat->callAPI('GET', 'https://api.chatwork.com/v2/rooms/155374207/messages?force=1', false);
        $response = json_decode($get_data, true);
        foreach ($response as $resp) {
           Messages_ChatWork::create(['message_id'=>array_get($resp, 'message_id'),
               'name'=>array_get($resp,'account.name'),
               'avatar'=>array_get($resp,'account.avatar_image_url'),
               'send_time'=>date('Y-m-d H:i:s', array_get($resp, 'send_time')),
               'message'=>array_get($resp,'body')
               ]);
        }

        dd('da them vao db');
    }

    public function getDataRealTime(){
        $get_data=$this->chat->callAPI('GET','https://api.chatwork.com/v2/rooms/155673778/messages?force=0',false);
        $response=json_decode($get_data,true);
        $message=$response;
        $options = array(
            'cluster' => 'mt1',
            'encrypted' => true
        );
        $pusher=new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $pusher->trigger('Notify','real-time-new-message-db',$message);

    }

    //db-client


    //call api + pagintion
//    public function getMessagesForceOne(Request $request)
//    {
//        $chat = new \ChatWorkAPI();
//        $get_data = $chat->callAPI('GET', 'https://api.chatwork.com/v2/rooms/155374207/messages?force=1', false);
//        $response = json_decode($get_data, true);
//        $get_members = $this->getMembers();
//        $currentPage = Paginator::resolveCurrentPage();
//        $col = collect($response);
//        $perPage = 10;
//        $currentPageItems = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
//        $items = new Paginator($currentPageItems, count($col), $perPage);
//        $items->setPath($request->url());
//        $items->appends($request->all());
//        foreach ($items as $item) {
//            $a = $chat->findMember($item['body'], $get_members);
//            $members[] = [
//                'id' => array_get($item, 'message_id'),
//                'name' => array_get($item, 'account.name'),
//                'avatar' => array_get($item, 'account.avatar_image_url'),
//                'send_time' => date('Y-m-d H:i:s', array_get($item, 'send_time')),
//                'message' => $chat->checkMessage($item['body']),
//                'avt' => $a,
//            ];
//        }
//
//
//        return view('admin.chat_work.index', compact('items', 'members'));
//    }

    public function getAllData(){
        $items=Messages_ChatWork::paginate(10);
        $get_members=$this->getMembers();
        foreach ($items as $item) {
//            dd($item);
            $a = $this->chat->findMember($item['message'], $get_members);
            $members[] = [
                'id' => array_get($item, 'message_id'),
                'name' => array_get($item, 'name'),
                'avatar' => array_get($item, 'avatar'),
                'send_time' =>  array_get($item, 'send_time'),
                'message' => $this->chat->checkMessage($item['message']),
                'avt' => $a,
            ];
        }
        return view('admin.chat_work.index',compact('items','members'));

    }

    public function getMembers()
    {
        $chat = new \ChatWorkAPI();
        $get_member = $chat->callAPI('GET', 'https://api.chatwork.com/v2/rooms/155374207/members', false);
        $response = json_decode($get_member, true);
        return $response;
    }

    public function getRooms()
    {
        $chat = new \ChatWorkAPI();
        $get_data = $chat->callAPI('GET', 'https://api.chatwork.com/v2/rooms', false);
        $response = json_decode($get_data, true);
        dd($response);
        return view('#');
    }

    public function create()
    {
        $chat = new \ChatWorkAPI();
        $chat->create();
        dd('thanh cong');
    }


}
