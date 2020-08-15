<?php

namespace App\Http\Middleware;

use Closure;
use App\Libs\Response;
use App\User;

class APITokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = request('token');
        $user = User::whereLoginToken($token)->first();

        if(!$token){
            return Response::invalid(['msg' => 'Invalid Token']);
        }

        if(!$user){
            return Response::invalid(['msg' => 'Invalid Token']);
        }

        return $next($request);
    }
}
