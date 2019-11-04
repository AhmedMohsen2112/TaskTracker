<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardListIssueHistory extends Model {

    /**
     * table name
     *
     * @var string
     */
    protected $table = "board_list_issue_history";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type','comment', 'description', 'issue_id', 'created_by'];

  

    /**
     * relationships
     *
     */
  

}
