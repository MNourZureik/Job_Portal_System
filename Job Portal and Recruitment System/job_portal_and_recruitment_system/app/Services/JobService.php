<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Tymon\JWTAuth\Facades\JWTAuth;

class JobService
{
    public function createJob(Request $request)
    {
        $validatedData = $request->validate(Job::rules());
        $user = JWTAuth::user();
        $validatedData['user_id'] = $user->id;
        return Job::create($validatedData);
    }

    public function fetchJobs(): \Illuminate\Database\Eloquent\Collection
    {
        return Job::all();
    }

    public function fetchJobById(int $id)
    {
        return Job::find($id);
    }

    public function updateJob(Request $request, int $id): bool
    {
        $job = Job::find($id);
        if ($job) {
            $validatedData = $request->validate(Job::rules());
            $validatedData['user_id'] = $job->user_id;
            $job->update($validatedData);
            return true;
        }
        return false;
    }

    public function deleteJob(int $id)
    {
        $job = Job::find($id);
        if (!$job || $job->user_id != JWTAuth::user()->id) {
            return (new Controller())->handleResponse(compact('job'), 'Job not found', 404);
        }
        return $job->delete();
    }

    public function searchJob(Request $request): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Job::query();

        foreach ($request->all() as $key => $value) {
            if (empty($value)) {
                continue;
            }
            // Check if the column exists in the 'jobs' table
            if (Schema::hasColumn('jobs', $key)) {
                // Check if the column is a string type to use 'LIKE', otherwise use exact match
                $columnType = Schema::getColumnType('jobs', $key);

                if (in_array($columnType, ['string', 'text'])) {
                    // Use 'LIKE' for string-based columns
                    $query->where($key, 'LIKE', "%$value%");
                } else {
                    // Use exact match for other types
                    $query->where($key, $value);
                }
            }
        }
        return $query->get();
    }

}
