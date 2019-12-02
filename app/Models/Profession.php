<?php

namespace App\Models;

use App\Traits\UserAssigned;
use Moloquent\Eloquent\SoftDeletes;

class Profession extends BaseModel
{
    use SoftDeletes, UserAssigned;

    protected $dates = [];

    protected $fillable = ['name', 'uname', 'description'];

    protected $hidden = [];

}
