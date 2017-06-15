<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    protected $table = 'tasks';
    protected $guarded = [''];
    protected $primaryKey = 'tasks_id';
}
