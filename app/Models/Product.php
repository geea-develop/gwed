<?php

namespace App\Models;

use App\Traits\UserAssigned;
use Moloquent\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use SoftDeletes, UserAssigned;

    protected $dates = [];

    protected $fillable = ['title', 'description', 'price', 'image', 'uname', 'category', 'logo', 'brand'];

    protected $hidden = [];
}
