<?php

namespace App\Services;

use App\Jobs\SendJobNotification;
use App\Models\JobListing;
use App\Models\users\Employer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JobService
{
    public function list()
    {
        $jobs = Cache::remember('all_jobs_list',
            600,
            static function () {
                $jobs = JobListing::with(['employer' => function ($query) {
                    $query->select('id', 'company_name', 'company_address', 'company_phone', 'company_email', 'company_website');
                }])->get();

                return $jobs->map(function ($job) {
                    $jobArray = $job->toArray();
                    unset($jobArray['employer_id'], $jobArray['deleted_at'], $jobArray['created_at'], $jobArray['updated_at']);
                    return $jobArray;
                });
            });
        if ($jobs->isEmpty()) {
            return false;
        }
        return $jobs;
    }

    public function store(Request $request): ?string
    {
        $validatedData = $request->validate(JobListing::rules());
        $validatedData['employer_id'] = Employer::where('user_id' , JWTAuth::user()->id)->get()->first()->id;
        DB::beginTransaction();
        try {
            $job = JobListing::create($validatedData);
            DB::commit();
            SendJobNotification::dispatch($job);
            return $job;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function fetch(int $id): Model|Collection|Builder|bool|array|null
    {
        $jobs = Cache::get("all_jobs_list");

        if($jobs){
            $jobExists = collect($jobs)->contains('id', $id);
            if($jobExists){
                return $jobExists;
            }
            return null;
        }
        return JobListing::with('employer')->findOrFail($id);
    }

    public function update(Request $request, int $id): ?JobListing
    {
        $validatedData = $request->validate(JobListing::rules());
        DB::beginTransaction();

        try {
            $job = JobListing::findOrFail($id);
            $job->update($validatedData);
            DB::commit();
            return $job;
        } catch (\Exception) {
            DB::rollback();
            return null;
        }
    }

    public function destroy(int $id): bool
    {
        DB::beginTransaction();

        try {
            $job = JobListing::findOrFail($id);
            $job->delete();
            DB::commit();
            return true;
        } catch (\Exception) {
            DB::rollback();
            return false;
        }
    }
}
