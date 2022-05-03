<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __constructor() {
        // gilt für alles außer login
        $this->middleware('auth:api', ['except'=>['login']]);
    }

    public function login() {
        $credentials = request(['email', 'password']);  // über welche Felder

        //check gegen user Tabelle (angegeben in config/auth)
        if (! $token=auth()->attempt($credentials)) {
            //error
            return response()->json(['error'=>'Unauthorized'], 401);
        } else {
            return $this->respondWithToken($token);
        }
    }

    // user aus dem jwt token rausbekommen
    public function me() {
        return response()->json(auth()->user());
    }

    public function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()*60
        ]);
    }

    //ausloggen und token invalidieren
    public function logout() {
        auth()->logout();
        return response()->json(['message'=>'Successfully logged out']);
    }
}
