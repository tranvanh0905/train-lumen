<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

    protected $table = 'task';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'user_id',
    ];
}
