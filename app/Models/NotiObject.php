<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotiObject extends Model {

    protected $table = 'noti_object';
    protected $fillable = ['entity_id', 'entity_type_id', 'user_id', 'notifiable_type'];

    

}
