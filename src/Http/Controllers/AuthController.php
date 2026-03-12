<?php

namespace Herisvanhendra\Pos\Http\Controllers;

use Illuminate\Http\Request;
use Herisvanhendra\Pos\Services\AuthService;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('pos::auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $this->authService->validateLoginRequest($request);
        
        $user = $this->authService->login($credentials);

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();
        }

        $this->authService->authenticate($user);

        return redirect()->route('pos.dashboard');
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('pos.login');
    }
}

