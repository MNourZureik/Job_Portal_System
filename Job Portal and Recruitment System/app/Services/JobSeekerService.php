<?php

namespace App\Services;

use App\Models\File;
use App\Models\users\JobSeeker;
use App\Services\helping_services\FileService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JobSeekerService
{
    protected FileService $file_service;

    public function __construct()
    {
        $this->file_service = new FileService();
    }

    /**
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(JobSeeker::rules());
        $validatedData['user_id'] = JWTAuth::user()->id;
        $jobSeeker = JobSeeker::create($validatedData);

        $profile_image_path = $this->file_service->uploadFile($request, 'profile_image' , 'profile_images');
        $resume_path = $this->file_service->uploadFile($request, 'resume' , 'resumes');

        $profile_image = $this->file_service->store($profile_image_path , 'profile_image' ,$jobSeeker->id , JobSeeker::class);
        $resume = $this->file_service->store($resume_path , 'resume' ,$jobSeeker->id , JobSeeker::class);

        if(!$profile_image || !$resume){
            return null;
        }
        $coordinates = $this->geocodeAddress($jobSeeker->address);

        if ($coordinates) {
            $jobSeeker->latitude = $coordinates['lat'];
            $jobSeeker->longitude = $coordinates['lng'];
        }
        else {
            return null;
        }
        $jobSeeker->save();
        return $jobSeeker;
    }

    /**
     * @throws \Exception
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate(JobSeeker::rules());
        $user = JWTAuth::user();
        $jobSeeker = JobSeeker::where('user_id', $user->id)->get()->first();

        $profile_image_path = $this->file_service->uploadFile($request, 'profile_image' , 'profile_images');
        $resume_path = $this->file_service->uploadFile($request, 'resume' , 'resumes');

        $profile_image = $this->file_service->store($profile_image_path , 'profile_image' ,$jobSeeker->id , JobSeeker::class);
        $resume = $this->file_service->store($resume_path , 'resume' ,$jobSeeker->id , JobSeeker::class);

        if (!$profile_image || !$resume){
            return false;
        }
        $jobSeeker->update($validatedData);
        return $jobSeeker;
    }

    public function destroy($id): bool
    {
        $JobSeeker = JobSeeker::find($id);
        File::where('fileable_id' , $id)->delete();
        if($JobSeeker){
            $JobSeeker->delete();
            return true;
        }
        return false;
    }

    public function show($id)
    {
        $JobSeeker = JobSeeker::where('id' , $id)->get()->first();
        $JobSeeker['profile_picture'] = File::where('fileable_id' , $id)->where('name' , 'profile_image')->get('path');
        if ($JobSeeker['profile_picture']->count() > 1) {
            $JobSeeker['profile_picture'] = $JobSeeker['profile_picture']->pluck('path');
        }
        else {
            $JobSeeker['profile_picture'] = $JobSeeker['profile_picture']->pluck('path')[0];
        }
        $JobSeeker['resume'] = File::where('fileable_id' , $id)->where('name' , 'resume')->get('path');
        if ($JobSeeker['resume']->count() > 1) {
            $JobSeeker['resume'] = $JobSeeker['resume']->pluck('path');
        }
        else {
            $JobSeeker['resume'] = $JobSeeker['resume']->pluck('path')[0];
        }
        if($JobSeeker){
            return $JobSeeker;
        }
        return false;
    }
}
