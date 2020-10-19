<?php

use App\Entity\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder{
    public function run(){
        User::create([
            'username'=>'Tony', 
            'stime'=>date("Y-m-d H:i:s"), 
            'password'=> Hash::make('password'),
            'email'=>'tony@mail.com', 

        ]);
    }
}