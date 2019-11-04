<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model {

    /**
     * table name
     *
     * @var string
     */
    protected $table = "boards";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'created_by'];

    /**
     * relationships
     *
     */
    public function lists() {
        return $this->hasMany(BoardList::class,'board_id','id');
    }
    
    /**
     * relationships data
     *
     */
    public function lists_data() {
        return $this->lists()->select(['board_lists.id', 'board_lists.title'])
                        ->get();
    }
    
     protected static function boot() {
        parent::boot();

        static::deleting(function($result) {
            foreach ($result->lists as $list) {
                $list->delete();
            }
        });
        static::deleted(function($result) {
            
        });
    }

}
