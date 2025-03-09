<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'email|unique:users,email|string',
            'password' => 'string|required|max:225|confirmed'
        ]);
        $user =  User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);
        return response()->json([
            'message' => 'Registration successful',
            'user'=>$user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|string',
            'password' => 'string|required'
        ]);
        if (!Auth::attempt($request->only('email', 'password')))
            return  response()->json(
                ['message' => 'login failed'],
                401
            );
        $user = User::where('email', $request->email)->FirstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return  response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "logout successful"
        ], 200);
    }
}
