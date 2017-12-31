<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $table = 'forums';

    public $primaryKey = 'id';
    public $timestamps = true;

    public function threads() {
        return $this->hasMany('App\Thread');
    }

    public function children() {
        return $this->hasMany('App\Forum', 'parent_id');
    }

    public function parent() {
        return $this->belongsTo('App\Forum', 'parent_id');
    }

    public function lastPost() {
        //I realize the forum doesn't belong to the post but that's the relationship I need for this method
        return $this->belongsTo('App\Post', 'last_post_id');
    }
}
