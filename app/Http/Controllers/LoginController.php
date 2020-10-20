<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{
    public function show(){
        return view('admin.login');
    }

    public function login(){
        $input = Input::all();
        //error_log(json_encode($input)); //

        $rules = [
            'email'=>'required|email',
            'password'=>'required'
        ];

        $validator = Validator::make($input, $rules);
  
        if($validator->passes()){
            error_log('success');
            $attempt = Auth::attempt([
                'email' => $input['email'],
                'password' => $input['password']
            ]);
    
            if ($attempt) {
                error_log('correct');
                return Redirect::intended('index'); //redirect page
            }
    
            return Redirect::to('login')
                    ->withErrors(['fail'=>'Email or password is wrong!']);
        }
        //fails
        error_log('fail');
        return Redirect::to('login')
            ->withErrors($validator)
            ->withInput(Input::except('password'));
            
      
    }
}