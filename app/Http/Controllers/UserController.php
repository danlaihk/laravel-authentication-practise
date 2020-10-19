<?php

namespace App\Http\Controllers;
use Log;
use DB;
use App\Entity\User;
class UserController extends Controller{
    public function test(){
        DB::listen(function($q){
            /*
            Log::info(
                $q->sql,
                $q->bindings,
                $q->time
            );
            */
            error_log('sql::'.$q->sql);
            //error_log('binding::'.json_encode($q->bindings));
            //error_log('time::'.$q->time);

        });
        
        return json_encode(User::all());
    }
}