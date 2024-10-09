<?php

namespace App\Models\users;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Employer extends User
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles ,SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_address',
        'company_phone',
        'company_email',
        'company_website',
        'company_logo',
    ];

    public function employer_rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',  // Ensure user_id exists in the users table
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_phone' => 'required|string|max:15',  // Phone numbers usually have a max length, you can adjust
            'company_email' => 'required|email|max:255|unique:employers,company_email',
            'company_website' => 'nullable|url|max:255',  // Optional, but if provided it must be a valid URL
            'company_logo' => 'nullable|string|max:255',  // Assuming it's a path to the logo
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class , 'employer_id');
    }
}
