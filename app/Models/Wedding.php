<?php

namespace App\Models;

use App\Traits\UserAssigned;
use Carbon\Carbon;
use Moloquent\Eloquent\SoftDeletes;

class Wedding extends BaseModel
{
    use SoftDeletes, UserAssigned;

    protected $dates = ['date'];

    protected $fillable = ['groomName', 'brideName', 'location', 'date', 'budget', 'guests'];

    protected $hidden = [];

    public function vendors() {
        return $this->hasMany(WeddingVendor::class, "weddingId");
    }

    public function guests() {
        return $this->hasMany(WeddingGuest::class, "weddingId");
    }

    public function events() {
        return $this->hasMany(Event::class, "weddingId");
    }

    public function scopeUpcomingWeddings($query)
    {
        return $query->where('date', '>', Carbon::tomorrow())->orderBy('date');
    }
}
