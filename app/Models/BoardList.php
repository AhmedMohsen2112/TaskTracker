<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardList extends Model {

    /**
     * table name
     *
     * @var string
     */
    protected $table = "board_lists";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'board_id', 'created_by'];

    /**
     * relationships
     *
     */
     public function board() {
        return $this->belongsTo(Board::class, 'board_id', 'id');
    }
    public function issues() {
        return $this->hasMany(BoardListIssue::class, 'list_id', 'id');
    }

    /**
     * relationships data
     *
     */
    public function issues_data() {
        return $this->issues()->select(['board_list_issues.id', 'board_list_issues.title', 'board_list_issues.description'])
                        ->orderBy('board_list_issues.ord')
                        ->get();
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($result) {
            foreach ($result->issues as $issue) {
                $issue->delete();
            }
        });
        static::deleted(function($result) {
            
        });
    }

}
