<?php

namespace App\Models;

use App\Traits\WeddingAssigned;
use Moloquent\Eloquent\SoftDeletes;

class WeddingVendor extends BaseModel
{
    use SoftDeletes, WeddingAssigned;

    protected $dates = [];

    protected $fillable = ['weddingId', 'vendorId'];

    protected $hidden = [];

    public function vendor() {
        return $this->hasOne(Vendor::class, "_id", "vendorId");
    }

}
