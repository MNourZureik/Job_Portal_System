<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use App\Services\AuthServices;
use App\Services\JobService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    // List all users (admin only)
    private JobService $jobService;
    private AuthServices $authService;

    public function __construct()
    {
        $this->authService = new AuthServices();
        $this->jobService = new JobService();
    }


    public function showUsers($role): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $users = $this->authService->listUsers($role);
        return  $this->handleResponse(compact('users') ,'user list', 200);
    }

    // Delete a job posting
    public function deleteJob(int $id): Response|ResponseFactory
    {
        try {
            $isDeleted = $this->jobService->deleteJob($id);
            return $isDeleted
                ? $this->handleResponse([], 'Job deleted successfully', 200)
                : $this->handleResponse([], 'Job could not be deleted', 404);
        } catch (\Exception $e) {
            return $this->handleResponse([], 'Error deleting job: ' . $e->getMessage(), 500);
        }
    }
}

