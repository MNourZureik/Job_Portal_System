<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Profile extends Model
{
    use HasFactory , HasTranslations;

    public $translatable = ['bio'];

    protected $fillable = [
        'bio',
        'phone',
        'linkedin',
        'github',
        'website',
        'profile_picture',
        'resume',
        'user_id',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
