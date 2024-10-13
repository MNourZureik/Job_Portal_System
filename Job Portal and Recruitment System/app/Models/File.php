<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'path',
        'fileable_id',
        'fileable_type',
    ];

    public function file(): MorphTo
    {
        return $this->morphTo();
    }

}
