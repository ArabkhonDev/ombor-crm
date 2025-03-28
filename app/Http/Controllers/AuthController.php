<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login funksiyasi (Basic Auth orqali)
     */
    public function login()
    {
        if (Auth::attempt(request(['email', 'password']))) {
            return response()->json(['message' => 'Tizimga muvaffaqiyatli kirdingiz!'], 200);
        }

        return response()->json(['message' => 'Login yoki parol noto‘g‘ri!'], 401);
    }

    /**
     * Logout funksiyasi
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Tizimdan chiqdingiz!'], 200);
    }

    /**
     * Ro'yxatdan o'tish (Register)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Foydalanuvchi muvaffaqiyatli yaratildi!', 'user' => $user], 201);
    }
}

