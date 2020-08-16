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

        // check if this user is logged in
        $user = User::whereUsername($request->username)->first();
        if($user->login_token !== NULL){
            return response()->json(['msg' => 'This account is already logged in !'], 401);
        }

        if(Auth::attempt($credentials, true)){
            $user = Auth::user();
            $user->update(['login_token' => bcrypt($user->id)]);

            return Response::success(['msg' => 'Login Successfully', 'user' => $user]);
        }

        return Response::invalid(['msg' => 'Invalid Login !']);

    }

    // post register
    public function register(Request $request){
        $data = [
            'username' => $request->username,
            'name' => $request->fullname,
            'password' => bcrypt($request->password)
        ];

        if(!$data || count($data) <= 3){
            return Response::invalid(['msg' => 'Invalid Form !']);
        }

        if($request->avatar){
            $data['avatar'] = 'users/' . $request->avatar . '.png';
        }

        $user = User::create($data);

        $user->update([
            'login_token' => bcrypt($user->id)
        ]);

        Auth::loginUsingId($user->id, true);

        return response()->json(['msg' => 'Register Successfully', 'user' => $user], 200);
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
