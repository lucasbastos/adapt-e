<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
//use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['role'] =  $user->role;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }

     /**
     * logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        if (Auth::check()) {
            $token = Auth::user()->token();
            $token->revoke();
            return response()->json(['error'=>'User is logout'], 203);
        } 
        else{ 
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $user = User::create($this->users_params($request));
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        $success['role'] =  $user->role;

        return response()->json(['success'=>$success], 201);
    }

    public function users_params($request)
    {
        $request['password'] = bcrypt($request->input('password'));
        return $request->all();
        
    }
}
