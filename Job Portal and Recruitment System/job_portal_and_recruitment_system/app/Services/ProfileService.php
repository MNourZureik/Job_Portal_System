<?php

namespace App\Services;

use App\Exceptions\FileException;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileService
{
    public function setProfile(ProfileRequest $request)
    {
        $fileService = new FileService();
        $validatedData = $request->validated();

        $user = JWTAuth::user();
        $validatedData['user_id'] = $user->id;

        try {
            $validatedData['profile_picture'] = $fileService->uploadFile($request, 'profile_picture', 'profile_pictures' );
            $validatedData['resume'] = $fileService->uploadFile($request, 'resume', 'resumes' );
        } catch (\Exception $e) {
            return false;
        }

        $profile = Profile::create($validatedData);
        $profile->setTranslation('bio', 'ar', $request->input('bio_ar'));
        $profile->setTranslation('bio', 'en', $request->input('bio_en'));
        $profile->save();
        return $profile;
    }

    public function getProfile($id): ProfileResource
    {
        $profile =Profile::where('user_id', $id)->get()->first();
        $profile->bio = json_decode($profile)->bio->ar;
        return ProfileResource::make($profile);
    }

}
