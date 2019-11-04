<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardListIssue extends Model {
    

    /**
     * table name
     *
     * @var string
     */
    protected $table = "board_list_issues";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'ord', 'list_id', 'created_by'];
    

    /**
     * upload folder
     *
     * @var string
     */
    public $upload_folder = "issues";

    /**
     * uploaded sizes
     *
     * @var array
     */
    public $sizes = array(
        'image' => [
            's' => array('width' => 160, 'height' => 160),
            'm' => array('width' => 800, 'height' => 750)
        ],
    );

    /**
     * relationships
     *
     */
     public function board_list() {
        return $this->belongsTo(BoardList::class, 'list_id', 'id');
    }
    public function attachment() {
        return $this->morphMany(AttachmentFile::class, 'attachment');
    }

    public function assigned() {
        return $this->belongsToMany(User::class, 'board_list_issue_assignment', 'issue_id', 'user_id');
    }
    public function comments() {
         return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * relationships lists
     *
     */
    public function assigned_list() {
        return $this->assigned()->whereNull('deleted_at')->select('id', 'name', 'phone')->get();
    }
    public function comments_list() {
        return $this->comments()->join('users','users.id','=','comments.created_by')
                ->select('comments.id', 'comments.comment','comments.created_at', 'users.name as username')
                ->orderBy('comments.created_at','desc')
                ->get();
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($result) {
            foreach ($result->attachment as $attachment) {
                $attachment->delete();
            }
            $result->assigned()->detach();
        });
        static::deleted(function($result) {
            
        });
    }

}
