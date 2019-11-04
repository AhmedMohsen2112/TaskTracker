<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable {

    /**
     * table name
     *
     * @var string
     */
    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','username', 'phone', 'email', 'password','active','type','group_id','created_by'];

    /**
     * relationships
     *
     */
    public function group() {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
    /**
     * relationships
     *
     */
    public function hotel_assigned() {
         return $this->belongsToMany(Hotel::class, 'hotel_assigned', 'assigned_id', 'hotel_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleted(function($user) {
            
        });
    }

}
