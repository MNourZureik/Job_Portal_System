<?php

namespace App\Http\Controllers;

use App\Services\JobService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JobSeekerController extends Controller
{
    // Search jobs with dynamic filters
    public function searchJob(Request $request): Response|ResponseFactory
    {
        $jobs = (new JobService())->searchJob($request);
        return $this->handleResponse(['jobs' => $jobs], 'Jobs retrieved successfully', 200);
    }
}
