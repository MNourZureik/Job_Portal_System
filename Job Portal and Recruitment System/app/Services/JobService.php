<?php

namespace App\Services;

use App\Jobs\SendJobNotification;
use App\Models\JobListing;
//use App\Models\Application;
use App\Models\users\Employer;
use App\Traits\GlobalFunctions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JobService
{
    use GlobalFunctions;
    public function list(): Collection
    {
        return Cache::remember('all_jobs_list',
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

//    public function getJobById(int $id): ?JobListing
//    {
//        return Cache::remember("job_{$id}", 600, function () use ($id) {
//            return JobListing::with('employer')->findOrFail($id);
//        });
//    }

    public function update(Request $request, int $id): ?JobListing
    {
        $validatedData = $request->validate(JobListing::rules());
        DB::beginTransaction();

        try {
            $job = JobListing::findOrFail($id);
            $job->update($validatedData);
            DB::commit();
            return $job;
        } catch (\Exception $e) {
            DB::rollback();
            return null;
        }
    }

//    public function deleteJob(int $id): bool
//    {
//        DB::beginTransaction();
//
//        try {
//            $job = JobListing::findOrFail($id);
//            $job->delete();
//            DB::commit();
//            return true;
//        } catch (\Exception $e) {
//            DB::rollback();
//            return false;
//        }
//    }
//
//    /**
//     * Apply for a job
//     *
//     * @param Request $request
//     * @param int $jobId
//     * @return Application|null
//     */
//    public function applyForJob(Request $request, int $jobId): ?Application
//    {
//        $request->validate([
//            'user_id' => 'required|integer',
//            'resume' => 'required|file|mimes:pdf,doc,docx',
//        ]);
//
//        DB::beginTransaction();
//
//        try {
//            $application = Application::create([
//                'user_id' => $request->input('user_id'),
//                'job_id' => $jobId,
//                'resume' => $request->file('resume')->store('resumes'),
//                'status' => 'pending',
//            ]);
//            DB::commit();
//            return $application;
//        } catch (\Exception $e) {
//            DB::rollback();
//            return null;
//        }
//    }
//
//    /**
//     * List applications for a job
//     *
//     * @param int $jobId
//     * @return mixed
//     */
//    public function listApplications(int $jobId)
//    {
//        return Application::where('job_id', $jobId)->paginate(10);
//    }
//
//    /**
//     * Feature a job
//     *
//     * @param int $id
//     * @return bool
//     */
//    public function featureJob(int $id): bool
//    {
//        try {
//            $job = JobListing::findOrFail($id);
//            $job->featured = true;
//            $job->save();
//            return true;
//        } catch (\Exception $e) {
//            return false;
//        }
//    }
//
//    /**
//     * Prune expired jobs
//     *
//     * @return bool
//     */
//    public function pruneExpiredJobs(): bool
//    {
//        try {
//            $expiredJobs = JobListing::where('start_date', '<', now())->get();
//
//            foreach ($expiredJobs as $job) {
//                $job->delete();
//            }
//
//            return true;
//        } catch (\Exception $e) {
//            return false;
//        }
//    }
//
//    /**
//     * Search for jobs using Laravel Scout
//     *
//     * @param string $searchTerm
//     * @return mixed
//     */
//    public function searchJobs(string $searchTerm)
//    {
//        return JobListing::search($searchTerm)->paginate(10);
//    }
}
