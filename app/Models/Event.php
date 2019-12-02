<?php

namespace App\Models;

use App\Traits\WeddingAssigned;
use Moloquent\Eloquent\SoftDeletes;

class Event extends BaseModel
{
    use SoftDeletes, WeddingAssigned;

    protected $dates = ['date'];

    protected $fillable = ['name', 'description', 'date'];

    protected $hidden = [];

}
