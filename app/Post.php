<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    public $primaryKey = 'id';
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function thread() {
        return $this->belongsTo('App\Thread');
    }

    public function forum() {
        return $this->belongsTo('App\Forum');
    }
}
