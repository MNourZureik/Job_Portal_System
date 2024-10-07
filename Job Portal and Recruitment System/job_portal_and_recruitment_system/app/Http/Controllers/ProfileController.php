<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Services\ProfileService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    protected ProfileService $profile_service;

    public function __construct() {
        $this->profile_service = new ProfileService();
    }

    public function setProfile(ProfileRequest $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $profile = $this->profile_service->setProfile($request);
        if ($profile) {
            return $this->handleResponse(compact('profile') , 'profile created successfully' , 200);
        }
        return $this->handleResponse(compact('profile') , 'some thing went wrong!' , 500);
    }

    public function getProfile($id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $profile = $this->profile_service->getProfile($id);
        return $this->handleResponse(compact('profile'), 'profile retrieved successfully', 200);
    }
}
