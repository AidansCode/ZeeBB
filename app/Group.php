<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public $primaryKey = 'id';
    public $timestamps = false;
}
