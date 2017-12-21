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
}
