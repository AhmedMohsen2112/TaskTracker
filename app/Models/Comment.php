<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    /**
     * table name
     *
     * @var string
     */
    protected $table = "comments";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['commentable_id', 'commentable_type','comment', 'created_by'];

  


}
