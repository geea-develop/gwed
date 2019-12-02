<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 19/07/17
 * Time: 20:12
 */

namespace App\Traits;

use App\Models\Wedding;

trait WeddingAssigned
{
    public function wedding() {
        return $this->hasOne(Wedding::class, "_id", "weddingId");
    }
}