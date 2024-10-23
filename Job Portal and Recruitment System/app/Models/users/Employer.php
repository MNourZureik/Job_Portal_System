<?php

namespace App\Models\users;

use App\Models\File;
use App\Models\JobListing;
use App\Models\User;
use App\Traits\GlobalFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Employer extends Model
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles ,SoftDeletes, GlobalFunctions;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_address',
        'company_phone',
        'company_email',
        'company_website',
    ];

    public static function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_phone' => 'required|string',  // Phone numbers usually have a max length, you can adjust
            'company_email' => 'required|email|max:255|unique:employers,company_email',
            'company_website' => 'required|url|max:255',  // Optional, but if provided it must be a valid URL
            'company_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(JobListing::class , 'employer_id');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
