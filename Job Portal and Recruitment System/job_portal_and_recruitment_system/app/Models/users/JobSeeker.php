<?php

namespace App\Models\users;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class JobSeeker extends User
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles ,SoftDeletes;

    protected $fillable = [
        'user_id',
        'profile_image',
        'resume',
        'skills',
        'experience',
        'education',
        'bio'
    ];

    public function jobSeeker_rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:10240',
            'skills' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_seeker_job');
    }

}
