<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\SingUpRequest;
use App\Http\Requests\Auth\SignInRequest;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function signUp(SingUpRequest $request){

        $validate = $request->validated();

        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => bcrypt($validate['name']),
            'picture' => env('AVATAR_GENERATOR_URL') . $validate['name'],
        ]);

        $token = auth()->login($user);
        if(!$token){
            return response()->json([
                "meta" => [
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Cannot add user'
                ],
                "data" => []
            ], 500);
        }

        return response()->json([
            "meta" => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Created susscessfully'
            ],
            "data" => [
                'user' =>[
                    'name' => $user->name,
                    'email' => $user->email,
                    'picture' => $user->picture,
                ],
                'access_token' => [
                    'token' => $token,
                    'type' => 'Bearer',
                    'expires_in' => strtotime('+' . auth()->factory()->getTTL(). ' minutes'),
                ]
            ]
        ], 200);
    }

    public function signIn(SignInRequest $request){
        $token = auth()->attempt($request->validated());

        if (!$token) {
            return response()->json([
                "meta" => [
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Incorrect email or password'
                ],
                "data" => []
            ], 401);
        }

        $user = auth()->user();

        return response()->json([
            "meta" => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Sign in successfully'
            ],
            "data" => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'picture' => $user->picture,
                ],
                'access_token' =>[
                    'token' => $token,
                    'type' => 'Bearer',
                    'expires_in' => strtotime('+' . auth()->factory()->getTTL(). ' minutes'),
                ]
            ]
        ], 200);
    }
}