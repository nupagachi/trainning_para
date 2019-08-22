<?php

class  ChatWorkAPI
{
    public function __construct()
    {

    }

    public function callAPI($method, $url, $data)
    {
        $curl = curl_init();
        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            default:
                break;
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'X-ChatWorkToken:2bd104255604bb191572c259158b8158',
            'Content-Type: application/json'
        ]);

        $result = curl_exec($curl);
        return $result;
    }

    public function findMember($body_item, $members)
    {
        $a = [];
        foreach ($members as $member) {
            $m = $member['account_id'];
            if (strpos($body_item, (string)$m)) {
                        array_push($a, $member);

            }
        }
        return $a;

    }
    public function findMemberByName($body_item,$members){
        $a=[];
        foreach ($members as $member) {
            $m = $member['name'];
            if (strpos($body_item, $m)) {
                array_push($a, $member);
            }
        }
        return $a;

    }

    public function checkMessage($messages)
    {
        $res='';
        $check=0;
    for($i=0;$i<strlen($messages);$i++){
        if($messages[$i]==='['){
            $check++;
        }

        if($check===0){
            $res=$res.$messages[$i];
        }

        if($messages[$i]===']'){
            $check--;
        }
    }
        return $res;

    }

    public function To($messages,$members)
    {
        if (strpos($messages, 'To')) {
            $a=$this->findMemberByName($messages,$members);
            dd($a);
        }
    }

    public function Re($messages,$members)
    {
        if (strpos($messages, 'Re')) {
           $a= $this->findMemberByName($messages,$members);
           dd($a);
        } else {
            return false;
        }
    }
    public function create(){

        $get_data=$this->callAPI('GET','https://api.chatwork.com/v2/rooms/155374207/messages?force=1',false);
        $response = json_decode($get_data, true);
        $chat=new \App\Http\Controllers\ChatWorkController();
        $get_members =$chat->getMembers();
        foreach ($response as $item) {
            $a = $this->findMember($item['body'], $get_members);

            $members[] = [
                'id' => array_get($item, 'message_id'),
                'name' => array_get($item, 'account.name'),
                'avatar' => array_get($item, 'account.avatar_image_url'),
                'send_time' => date('Y-m-d H:i:s', array_get($item, 'send_time')),
                'message' => $this->checkMessage($item['body']),
                'avt' => $a,
            ];
        }

        foreach ($members as $member) {
            \App\Messages_ChatWork::create([
               'messages_id'=>$member['id'],
               'name'=>$member['name'],
               'messages'=>$member['message'],
               'avatar'=>$member['avatar'],
               'users_images'=>$member['avt']
            ]);
        }

    }




}