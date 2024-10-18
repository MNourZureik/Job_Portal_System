<?php

namespace App\Models;

use App\Models\users\Admin;
use App\Models\users\Employer;
use App\Models\users\JobSeeker;
use App\Traits\globalFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticate implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles ,SoftDeletes , GlobalFunctions;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public static function rules(bool $is_register = false , bool $is_google = false): array
    {
        $password = $is_google ? 'nullable' : 'required|string|min:8';
        return $is_register ? [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => $password,
            'role' => 'required|string|in:job_seeker,employer,admin',
            'phone_number' => 'required|string|max:10|min:10',
        ] :
        [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ];
    }

    public function employers(): HasMany
    {
        return $this->hasMany(Employer::class);
    }

    public function job_seekers(): HasMany
    {
        return $this->hasMany(JobSeeker::class);
    }

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }
}
