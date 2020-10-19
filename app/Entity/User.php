<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    protected $table = 'Users';
    public $timestamps = false;
}