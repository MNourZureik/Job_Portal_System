<?php

namespace App\Http\Controllers;

use App\Services\AuthServices;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthController extends Controller
{
    // User registration
    protected AuthServices $authService;

    public function __construct() {
        $this->authService = new AuthServices();
    }

    public function register(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
            $user = $this->authService->StoreUser($request);
            if ($user) {
                return $this->handleResponse(compact('user'), 'Registration successful', 201); // 201 for successful creation
            } else {
                return $this->handleResponse([], 'Registration failed', 422); // Unprocessable entity
            }
    }


    // User login
    public function login(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
            $credentials = $this->authService->login($request);
            $token = JWTAuth::attempt($credentials);

            if ($token) {
                return $this->handleResponse(compact('token'), 'Login successful', 200);
            } else {
                return $this->handleResponse([], 'Invalid credentials', 401); 
            }
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
}
