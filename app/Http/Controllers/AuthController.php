<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistroRequest;
use App\Http\Requests\LoginRequest;

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

        // Buscar al usuario por correo electrónico
        $user = User::where('email', $data['email'])->first();

        // Verificar la contraseña
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas.',
            ], 401); // Código de estado HTTP 401: No autorizado
        }

        // Retornar un token en caso de éxito
        return response()->json([
            'token' => $user->createToken('authToken')->plainTextToken,
            "user" => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            "user" => "Cerraste Sesión"
        ];
    }
}
