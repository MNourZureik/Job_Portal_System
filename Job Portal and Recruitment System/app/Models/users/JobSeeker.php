<?php

namespace App\Models\users;

use App\Models\File;
use App\Models\JobListing;
use App\Models\User;
use App\Traits\GlobalFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class JobSeeker extends Model
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles ,SoftDeletes, GlobalFunctions;

    protected $fillable = [
        'user_id',
        'skills',
        'experience',
        'education',
        'bio'
    ];

    public static function rules(): array
    {
        return [
            'skills' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'resume' => 'required|mimes:pdf,doc,docx,ppt,pptx',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(JobListing::class, 'job_seeker_job');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
