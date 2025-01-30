<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistroRequest;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function registro(RegistroRequest $request)
    {
        // Validate and get the data from the request
        $data = $request->validated();

        // Create a new user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Return the generated token
        return [
            'token' => $user->createToken('authToken')->plainTextToken,
            "user" => $user
        ];
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();


        if(!Auth::attempt($data)){
            return response([
                "errors" => ["El email o el password son incorrectos"]
            ], 422);
        }

        //autenticar
        $user = Auth::user();
        return [
            "token" => $user->createToken("token")->plainTextToken,
            "user" => $user
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            "user" => "Cerraste Sesión"
        ];
    }
}
