<?php

namespace App\Models;

use App\Traits\WeddingAssigned;
use Moloquent\Eloquent\SoftDeletes;

class WeddingGuest extends BaseModel
{
    use SoftDeletes, WeddingAssigned;

    protected $dates = [];

    protected $fillable = ['weddingId', 'guestId'];

    protected $hidden = [];

    public function guest() {
        return $this->hasOne(Guest::class, "_id", "guestId");
    }

}
