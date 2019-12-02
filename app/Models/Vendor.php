<?php

namespace App\Models;

use App\Traits\UserAssigned;
use Moloquent\Eloquent\SoftDeletes;

class Vendor extends BaseModel
{
    use SoftDeletes, UserAssigned;

    protected $dates = [];

    protected $fillable = ['name', 'email', 'phone', 'cost'];

    protected $hidden = [];

    public function professions() {
        return $this->hasMany(VendorProfession::class, "vendorId");
    }

    public function weddings() {
        return $this->hasMany(WeddingVendor::class, "vendorId");
    }
}
