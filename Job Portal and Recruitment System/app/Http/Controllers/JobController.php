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

//    public function show($id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
//    {
//        $job = $this->jobService->getJobById($id);
//
//        if ($job) {
//            return $this->handleResponse(compact('job'), 'JobListing fetched successfully', 200);
//        }
//
//        return $this->handleResponse([], 'JobListing not found', 404);
//    }

//    public function edit($id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
//    {
//        $job = $this->jobService->getJobById($id);
//
//        if ($job) {
//            return view('jobs.edit', compact('job'));
//        }
//
//        return $this->handleResponse([], 'JobListing not found', 404);
//    }
//
    public function update(Request $request, $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $job = $this->jobService->update($request, $id);

        if ($job) {
            Cache::forget("job_{$id}");
            return $this->handleResponse(compact('job'), 'JobListing updated successfully', 200);
        }

        return $this->handleResponse([], 'JobListing update failed', 422);
    }

//    public function destroy($id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
//    {
//        $deleted = $this->jobService->deleteJob($id);
//
//        if ($deleted) {
//            Cache::forget("job_{$id}");
//            return $this->handleResponse(null, 'JobListing deleted successfully', 200);
//        }
//
//        return $this->handleResponse([], 'JobListing deletion failed', 500);
//    }

//    public function apply(Request $request, $jobId): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
//    {
//        $application = $this->jobService->applyForJob($request, $jobId);
//
//        if ($application) {
//            return $this->handleResponse(compact('application'), 'Application submitted successfully', 201);
//        }
//
//        return $this->handleResponse([], 'Application submission failed', 422);
//    }
//
//    // List applications for a job
//    public function applications($jobId): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
//    {
//        $applications = $this->jobService->listApplications($jobId);
//
//        if ($applications) {
//            return view('jobs.applications', compact('applications'));
//        }
//
//        return $this->handleResponse([], 'No applications found', 404);
//    }
//
//    // Feature job on homepage
//    public function feature($id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
//    {
//        $featured = $this->jobService->featureJob($id);
//
//        if ($featured) {
//            Cache::flush();
//            return $this->handleResponse(null, 'JobListing featured successfully', 200);
//        }
//
//        return $this->handleResponse([], 'Failed to feature job', 422);
//    }
//
//    // Archive expired jobs (pruning functionality)
//    public function pruneExpiredJobs(): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
//    {
//        $pruned = $this->jobService->pruneExpiredJobs();
//
//        if ($pruned) {
//            Cache::flush();
//            return $this->handleResponse(null, 'Expired jobs pruned successfully', 200);
//        }
//
//        return $this->handleResponse([], 'Failed to prune expired jobs', 500);
//    }
//
//    // Broadcast live updates using Redis Pub/Sub
//    public function broadcastJobUpdate($id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
//    {
//        $job = $this->jobService->getJobById($id);
//
//        if ($job) {
//            Redis::publish('job-updates', json_encode($job));
//            return $this->handleResponse(null, 'JobListing update broadcasted successfully', 200);
//        }
//
//        return $this->handleResponse([], 'JobListing not found for broadcasting', 404);
//    }
//
//    // Search for jobs using Laravel Scout
//    public function search(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
//    {
//        $jobs = $this->jobService->searchJobs($request->input('search'));
//
//        if ($jobs) {
//            return $this->handleResponse(compact('jobs'), 'Jobs found', 200);
//        }
//
//        return $this->handleResponse([], 'No jobs found for search query', 404);
//    }
}
