<?php

namespace App\Models;

use App\Traits\UserAssigned;
use Moloquent\Eloquent\SoftDeletes;

class Guest extends BaseModel
{
    use SoftDeletes, UserAssigned;

    protected $dates = [];

    protected $fillable = ['name', 'email', 'phone', 'type', 'side'];

    protected $hidden = [];

}
