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
        app()->setLocale('ar');
        $validatedData = $request->validated();
        $user = JWTAuth::user();
        $validatedData['user_id'] = $user->id;

        try {
            $validatedData['profile_picture'] = $this->is_has_file($request, $user->profile, 'profile_picture', 'profile_pictures');
            $validatedData['resume'] = $this->is_has_file($request, $user->profile, 'resume', 'resumes');
        } catch (FileException $e) {
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


    /**
     * @throws FileException
     */
    public function is_has_file(ProfileRequest $request  , $model , $file_name , $path): bool|string
    {
        if ($request->hasFile($file_name)) {
            if ($model && $model->$file_name) {
                Storage::delete($model->$file_name);
            }
            $originalName = $request->file($file_name)->getClientOriginalName();
            return $request->file($file_name)->storeAs($path, $originalName);
        }
        throw new \App\Exceptions\FileException();
    }
}
