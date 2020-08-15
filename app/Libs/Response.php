<?php

namespace App\Libs;

class Response{
    public static function success($response){
        return response()->json($response, 200);
    }
    public static function invalid($response){
        return response()->json($response, 401);
    }
    public static function forbidden($response){
        return response()->json($response, 403);
    }
    public static function notfound($response){
        return response()->json($response, 404);
    }
}
