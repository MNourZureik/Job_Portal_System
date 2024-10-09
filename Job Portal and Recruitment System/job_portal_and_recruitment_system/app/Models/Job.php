<?php

namespace App\Models;

use App\Models\users\Employer;
use App\Models\users\JobSeeker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Job extends Model
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles , SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'job_type',
        'company',
        'location',
        'city',
        'country',
        'remotely',
        'salary_range',
        'currency',
        'salary_type',
        'start_date',
        'end_date',
        'duration',
        'status',
        'required_skills',
        'employer_id',
    ];
    public static function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'job_type' => 'required|string',
            'company' => 'required|string',
            'location' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'remotely' => 'required|string',
            'salary' => 'required|integer',
            'currency' => 'required|string',
            'salary_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'duration' => 'required|string',
            'status' => 'required|string',
            'required_skills' => 'required|string',
            'employer_id' => 'required|integer',
        ];
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function jobSeekers(): BelongsToMany
    {
        return $this->belongsToMany(JobSeeker::class, 'job_seeker_job');
    }

}
