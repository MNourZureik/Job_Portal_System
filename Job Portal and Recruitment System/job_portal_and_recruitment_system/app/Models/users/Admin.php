<?php

namespace App\Models\users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends User
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles ,SoftDeletes;

    protected $fillable = [
        'user_id',
        'access_level',
        'status',
    ];

    public function admin_rules()
    {
        return [
            'user_id' => 'required|exists:users,id',  // Ensure the user_id exists in the users table
            'access_level' => 'required|in:low,medium,high',  // Only allow 'low', 'medium', or 'high' access levels
            'status' => 'required|in:active,inactive,suspended',  // Only allow valid statuses
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
