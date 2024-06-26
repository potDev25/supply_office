<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        $credentials = $request->validated();

        if(!Auth::attempt($credentials)){
            return response([
                'message_error' => 'Invalid Credentials'
            ], 422);
        }

       /** @var User $user **/
        $user = Auth::user();
        $user_token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'user_token'));
    }

    public function logout(Request $request){
        $user = $request->user();
        /** @var User $user **/
        $user->currentAccessToken()->delete();
    }
}
