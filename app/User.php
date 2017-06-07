<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function ideas()
    {
        return $this->hasMany(Idea::class, 'author');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }
}