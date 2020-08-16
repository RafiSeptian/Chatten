<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libs\Response;
use Illuminate\Support\Facades\Cookie;
use App\User;

class AuthController extends Controller
{
    protected $token;
    protected $user;

    public function __construct(){
        $this->token = request('token');
        $this->user = \App\User::whereLoginToken($this->token)->first();
    }

    // show login method
    public function showLogin(){
        return view('auth.login');
    }

    // post login method
    public function login(Request $request){
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials, true)){
            $user = Auth::user();

            // check if this user is logged in
            if($user->login_token !== NULL){
                return Response::invalid(['msg' => 'This account is already logged in !']);
            }

            // set user token
            $user->update(['login_token' => bcrypt($user->id)]);
            return Response::success(['msg' => 'Sign in successfully', 'user' => $user]);
        }

        return Response::invalid(['msg' => 'Invalid Login !']);

    }

    // post register
    public function register(Request $request){

        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'password' => 'required'
        ]);

        $data = [
            'username' => $request->username,
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ];


        if($request->avatar){
            $data['avatar'] = 'users/' . $request->avatar . '.png';
        }

        $user = User::create($data);

        $user->update([
            'login_token' => bcrypt($user->id)
        ]);

        Auth::loginUsingId($user->id, true);

        return response()->json(['msg' => 'Sign up successfully', 'user' => $user], 200);
    }

    public function logout(Request $request){
        if(!$this->token || !$this->user){
            return Response::invalid(['msg' => 'Invalid Token']);
        }

        $this->user->update(['login_token' => null]);
        Auth::logout();

        return Response::invalid(['msg' => 'Invalid Token']);
    }
}
