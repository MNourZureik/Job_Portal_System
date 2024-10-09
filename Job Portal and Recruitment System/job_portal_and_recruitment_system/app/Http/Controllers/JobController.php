<?php
namespace App\Http\Controllers;

use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Query\IndexHint;

class JobController extends Controller
{
    protected JobService $jobService;

    // Inject JobService via the constructor (Dependency Injection)
    public function __construct()
    {
        $this->jobService = new JobService();
    }

    // Create a new job posting (for employers)
    public function createJob(Request $request): Response|ResponseFactory
    {
        try {
            $job = $this->jobService->createJob($request);
            return $this->handleResponse(['job' => $job], 'Job created successfully', 201);
        } catch (\Exception $e) {
            return $this->handleResponse([], 'Failed to create job: ' . $e->getMessage(), 500);
        }
    }

    // List all jobs
    public function listJobs(): Response|ResponseFactory
    {
        $jobs = $this->jobService->fetchJobs();
        return $this->handleResponse(['jobs' => $jobs], 'Jobs retrieved successfully', 200);
    }

    // Fetch a job by its ID
    public function fetchJobById(int $id): Response|ResponseFactory
    {
        $job = $this->jobService->fetchJobById($id);

        return $job
            ? $this->handleResponse(['job' => $job], 'Job retrieved successfully', 200)
            : $this->handleResponse([], 'Job not found', 404);
    }

    // Update a job posting
    public function updateJob(int $id, Request $request): Response|ResponseFactory
    {
        try {
            $isUpdated = $this->jobService->updateJob($request, $id);
            return $isUpdated
                ? $this->handleResponse([], 'Job updated successfully', 200)
                : $this->handleResponse([], 'Job could not be updated', 404);
        } catch (\Exception $e) {
            return $this->handleResponse([], 'Error updating job: ' . $e->getMessage(), 500);
        }
    }
}


// index list of ob
// show
