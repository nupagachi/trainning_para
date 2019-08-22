<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages_ChatWork extends Model
{
    protected $table = ('messages_chatwork');
    public $primaryKey = 'id';

    protected $fillable = [
        'name', 'message_id', 'avatar','message','send_time'
    ];


}
