<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $table = 'threads';

    public $primaryKey = 'id';
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function forum() {
        return $this->belongsTo('App\Forum');
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }
}
