<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Job extends Model
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    protected $fillable = [
        'title',
        'description',
        'job_type',
        'company',
        'user_id',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'job_type' => 'required|string',
            'company' => 'required|string',
        ];
    }
}
