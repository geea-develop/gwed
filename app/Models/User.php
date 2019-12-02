<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Moloquent\Eloquent\SoftDeletes;

use Moloquent\Auth\User as BaseUser;

/**
 * Class User
 * @package App\Models
 */
class User extends BaseUser
{
    use Notifiable, SoftDeletes, HasApiTokens;

    protected $fillable = ['name', 'email', 'password',];

    protected $hidden = ['password', 'remember_token'];

    public function weddings() 
    {
        return $this->hasMany(Wedding::class, 'userId');
    }

    public function professions()
    {
        return $this->hasMany(Profession::class, 'userId');
    }

    public function guests()
    {
        return $this->hasMany(Guest::class, 'userId');
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'userId');
    }
}
