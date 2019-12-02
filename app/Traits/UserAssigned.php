<?php

namespace App\Traits;

use App\Models\User;

/**
 * Created by PhpStorm.
 * User: guy
 * Date: 19/07/17
 * Time: 20:07
 */
trait UserAssigned
{
    public function user() {
        return $this->hasOne(User::class, "_id", "userId");
    }
}