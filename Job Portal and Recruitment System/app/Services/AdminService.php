<?php

namespace App\Services;

use App\Models\File;
use App\Models\users\Admin;
use App\Services\helper_services\FileService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminService
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
        $validatedData = $request->validate(Admin::rules());
        $validatedData['user_id'] = JWTAuth::user()->id;
        $admin = Admin::create($validatedData);
        $path = $this->file_service->uploadFile($request, 'profile_image' , 'profile_images');

        $file = $this->file_service->store($path, 'profile_image' , $admin->id , Admin::class);
        if (!$file) {
            return null;
        }
        return $admin;

    }

    /**
     * @throws \Exception
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate(Admin::rules());
        $admin = Admin::where('user_id', JWTAuth::user()->id)->get()->first();

        $path = $this->file_service->uploadFile($request, 'profile_image' , 'profile_images');

        $file = $this->file_service->store($path, 'profile_image' , $admin->id , Admin::class);
        if (!$file) {
            return null;
        }
        $admin->update($validatedData);
        return $admin;
    }

    public function destroy($id): bool
    {
        $admin = Admin::find($id);
        File::where('fileable_id' , $id)->delete();
        if($admin){
            $admin->delete();
            return true;
        }
        return false;
    }

    public function show($id)
    {
       $admin = Admin::where('id' , $id)->get()->first();
       $admin['profile_image'] = File::where('fileable_id' , $admin->id)->get()->first()->path;
       if($admin){
           return $admin;
       }
       return false;
    }

}
