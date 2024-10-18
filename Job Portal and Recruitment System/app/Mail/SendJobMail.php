<?php

namespace App\Mail;

use App\Models\JobListing;
use App\Models\User; // Assuming users are job seekers
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendJobMail extends Mailable
{
    use Queueable, SerializesModels;

    public JobListing $job;
    public string $jobSeeker_name;

    /**
     * Create a new message instance.
     *
     * @param JobListing $job
     * @param string jobSeeker_name
     */
    public function __construct(JobListing $job, string $jobSeeker_name)
    {
        $this->job = $job;
        $this->jobSeeker_name = $jobSeeker_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Job Opportunity: ' . $this->job->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.jobs.notification',
            with: [
                'jobTitle' => $this->job->title,
                'company' => $this->job->company,
                'location' => $this->job->location,
                'city' => $this->job->city,
                'country' => $this->job->country,
                'jobType' => $this->job->job_type,
                'salary' => $this->job->salary,
                'currency' => $this->job->currency,
                'salaryType' => $this->job->salary_type,
                'remotely' => $this->job->remotely,
                'startDate' => $this->job->start_date,
                'endDate' => $this->job->end_date,
                'requiredSkills' => $this->job->required_skills,
                'description' => $this->job->description,
                'jobSeekerName' => $this->jobSeeker_name,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
