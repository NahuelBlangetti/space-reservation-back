<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar al usuario
        if (! $token = JWTAuth::attempt($validated)) {
            return response()->json([
                'message' => 'Login information invalid.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Si la autenticación es exitosa, devolver el token JWT
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function register(Request $request)
    {
        // Validar los datos de registro
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);
    
        // Encriptar la contraseña
        $validated['password'] = Hash::make($validated['password']);
    
        // Crear el usuario
        $user = User::create($validated);
    
        // Generar el token JWT para el nuevo usuario
        $token = JWTAuth::fromUser($user);
    
        // Devolver los datos del usuario y el token
        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], Response::HTTP_CREATED);
    }

    public function unauthorized()
    {
        return response()->json([
            'message' => 'Unauthorized',
        ], Response::HTTP_UNAUTHORIZED);
    }
}
