<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardListIssueAssignment extends Model {

    /**
     * table name
     *
     * @var string
     */
    protected $table = "board_list_issue_assignment";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'issue_id'];

 

    /**
     * relationships
     *
     */
 

}
