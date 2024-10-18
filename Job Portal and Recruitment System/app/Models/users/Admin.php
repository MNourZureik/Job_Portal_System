<?php

namespace App\Models\users;

use App\Models\User;
use App\Traits\GlobalFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles ,SoftDeletes, GlobalFunctions;

    protected $fillable = [
        'user_id',
        'access_level',
        'status',
    ];

    public static function rules(): array
    {
        return [
            'access_level' => 'required|in:low,medium,high',  // Only allow 'low', 'medium', or 'high' access levels
            'status' => 'required|in:active,inactive,suspended',  // Only allow valid statuses
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
