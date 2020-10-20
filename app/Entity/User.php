<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    use Notifiable;
    protected $table = 'Users';
    public $timestamps = false;

    protected $fillable = [
        'username', 'email', 'password', 'stime'
    ];

    protected $hidden = ['remember_token'];
}