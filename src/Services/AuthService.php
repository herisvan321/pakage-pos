<?php

namespace Herisvanhendra\Pos\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Herisvanhendra\Pos\Models\User;

class AuthService
{
    /**
     * Validate login credentials
     */
    public function login(array $credentials): ?User
    {
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $user;
        }

        return null;
    }

    /**
     * Authenticate user
     */
    public function authenticate(User $user): void
    {
        Auth::login($user);
        request()->session()->regenerate();
    }

    /**
     * Logout user
     */
    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    /**
     * Validate login request
     */
    public function validateLoginRequest(Request $request): array
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }

    /**
     * Validate register request
     */
    public function validateRegisterRequest(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    /**
     * Register new user
     */
    public function register(array $credentials): User
    {
        return User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
        ]);
    }
}

