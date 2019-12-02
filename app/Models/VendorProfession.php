<?php

namespace App\Models;

use Moloquent\Eloquent\SoftDeletes;

class VendorProfession extends BaseModel
{
    use SoftDeletes;

    protected $dates = [];

    protected $fillable = ['vendorId', 'professionId'];

    protected $hidden = [];

    public function vendor() {
        return $this->hasOne(Vendor::class, "_id", "vendorId");
    }

    public function profession() {
        return $this->hasOne(Profession::class, "_id", "professionId");
    }

    public function user() {
        return $this->vendor()->user();
    }
}
