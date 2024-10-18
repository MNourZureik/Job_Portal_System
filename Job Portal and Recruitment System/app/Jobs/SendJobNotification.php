<?php

namespace App\Jobs;

use App\Mail\SendJobMail;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendJobNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected JobListing $job_list;
    /**
     * Create a new job instance.
     */
    public function __construct(JobListing $job)
    {
        $this->job_list = $job;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobSeekers = User::where('role', 'job_seeker')->get();

        foreach ($jobSeekers as $jobSeeker) {
            Mail::to($jobSeeker->email)->send(new SendJobMail($this->job_list, $jobSeeker->name));
        }
    }
}
