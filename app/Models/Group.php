<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

    /**
     * table name
     *
     * @var string
     */
    protected $table = "groups";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'permissions', 'active', 'created_by'];

    /**
     * relationships
     *
     */
    public function users() {
        return $this->hasMany(User::class);
    }

}
