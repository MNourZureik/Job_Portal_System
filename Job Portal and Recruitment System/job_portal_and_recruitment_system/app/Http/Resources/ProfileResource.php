<?php

namespace App\Http\Resources;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'bio' => $this->bio,  // Handle the 'bio' field safely
            'phone' => $this->phone,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
            'website' => $this->website,
            'profile_picture' => $this->profile_picture,
            'resume' => $this->resume,
            'user_id' => $this->user_id,
        ];
    }
}
