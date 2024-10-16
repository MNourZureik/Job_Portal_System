<?php

namespace App\Http\Controllers;

use App\Services\AuthServices;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;
use Random\RandomException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // User registration
    protected AuthServices $authService;

    public function __construct() {
        $this->authService = new AuthServices();
    }

    public function register(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
            $user = $this->authService->store($request);
            if ($user) {
                return $this->handleResponse(compact('user'), 'Registration successful', 201); // 201 for successful creation
            }

        return $this->handleResponse([], 'Registration failed', 422); // Unprocessable entity
    }


    // User login

    /**
     * @throws RandomException
     */
    public function login(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
            $credentials = $this->authService->login($request);
            $token = JWTAuth::attempt($credentials);

            if ($token) {
                $this->authService->sendVerificationCode($request->input('email'));
                return $this->handleResponse(compact('token'), 'Login successful', 200);
            }

        return $this->handleResponse([], 'Invalid credentials', 401);
    }

    // Logout and invalidate the token
    public function logout(): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken()); // Ensure that the token exists and is valid
            return $this->handleResponse(null, 'Logged out successfully', 200);
        } catch (\Exception $e) {
            return $this->handleResponse(null, 'Logout failed: ' . $e->getMessage(), 500);
        }
    }

    public function verify(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $is_valid = $this->authService->checkVerificationCode($request->input('code'));
        if ($is_valid) {
            return $this->handleResponse(compact('is_valid'), 'Verification successful', 200);
        }
        return $this->handleResponse(compact('is_valid'), 'Verification failed', 400);
    }

    public function google(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback(): \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|Response
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $newUser = $this->authService->handle($googleUser);

            $token = JWTAuth::fromUser($newUser);

            return $this->handleResponse(compact('token'), 'Login successful', 200);
        } catch (\Exception $e) {
            return $this->handleResponse([], 'Login failed: ' . $e->getMessage(), 500);
        }
    }
}
