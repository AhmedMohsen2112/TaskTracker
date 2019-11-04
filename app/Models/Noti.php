<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Noti extends Model {

    protected $table = 'noti';
    protected $fillable = ['notifier_id', 'noti_object_id','read_status'];

}
