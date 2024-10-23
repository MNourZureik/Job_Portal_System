<?php

namespace App\Http\Controllers;

use App\Services\JobService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class JobController extends Controller
{
    protected JobService $jobService;

    public function __construct() {
        $this->jobService = new JobService();
    }

    // Display a listing of the resource (All jobs)
    public function index(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $jobs = $this->jobService->list();

        if ($jobs) {
            return $this->handleResponse(compact('jobs'), 'Jobs fetched successfully', 200);
        }
        return $this->handleResponse([], 'No jobs found', 404);
    }


    // Store a newly created resource in storage (create a new job)
    public function store(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $job = $this->jobService->store($request);

        if ($job) {
            return $this->handleResponse(compact('job'), 'JobListing posted successfully', 201);
        }
        return $this->handleResponse(compact('job'), 'JobListing creation failed', 422);
    }

    public function fetch($id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $job = $this->jobService->fetch($id);

        if ($job) {
            return $this->handleResponse(compact('job'), 'JobListing fetched successfully', 200);
        }

        return $this->handleResponse([], 'JobListing not found', 404);
    }

    public function update(Request $request, $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $job = $this->jobService->update($request, $id);

        if ($job) {
            Cache::forget("all_jobs_list");
            return $this->handleResponse(compact('job'), 'JobListing updated successfully', 200);
        }

        return $this->handleResponse([], 'JobListing update failed', 422);
    }

    public function destroy($id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $deleted = $this->jobService->destroy($id);

        if ($deleted) {
            return $this->handleResponse(null, 'JobListing deleted successfully', 200);
        }

        return $this->handleResponse([], 'JobListing deletion failed', 500);
    }
}
