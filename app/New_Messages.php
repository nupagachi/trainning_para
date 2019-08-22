<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class New_Messages extends Model
{
    protected $table = ('new_messages');
    public $primaryKey = 'id';

    protected $fillable = [
        'name', 'message_id', 'avatar','message','send_time'
    ];

}
