<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Entity\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;
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
            //error_log('success');
            $attempt = Auth::attempt([
                'email' => $input['email'],
                'password' => $input['password']
            ]);
    
            if ($attempt) {
                //error_log('correct');
                return Redirect::intended('index'); //redirect page
            }
    
            return Redirect::to('login')
                    ->withErrors(['fail'=>'Email or password is wrong!']);
        }
        //fails
        //error_log('fail');
        return Redirect::to('login')
            ->withErrors($validator)
            ->withInput(Input::except('password'));
            
      
    }

    public function apiLogin(Request $request){
        $input = $request->all();
        //error_log($request);
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
        $validator = Validator::make($input,[
            'email'=>[
                'required','string','email','max:255'
            ],
            'password'=>[
                'required','string','min:6','max:12'
            ]
        ]);
        if($validator->passes()){
            //error_log('valided');
            //error_log(json_encode($input));
            //error_log($input['email']);

   
            $user = User::where('email',$request->email)
                    ->first();
            if($user){
                //error_log(json_encode($user));
                //has user, then check hash password
                if(Hash::check($request->password, $user->password)){
                  
                    $apiToken = Str::random(100);
                    $user->{'api_token'} = $apiToken;
                    $updateResult = $user->save();
                    if ($updateResult) { //更新 api_token
                        $result = [
                            'state'=>'success',
                            'api-token'=>$apiToken
                        ];
                    }else{
                        $result = [
                            'state'=>'error',
                            'api-token'=>''
                        ];
                    }
                }else{
                    $result = [
                        'state'=>'error',
                        'api-token'=>''
                    ];
                }
            }else{
                $result = [
                    'state'=>'error',
                    'api-token'=>''
                ];
               
            }
            return json_encode($result);

        }else{
            return $this->sendError('Validation Error.', $validator->errors());

        }
       
        
    }
}