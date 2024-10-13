<?php

namespace App\Services;

use App\Models\File;
use App\Models\users\Employer;
use App\Services\helper_services\FileService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class EmployerService
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
        $validatedData = $request->validate(Employer::rules());
        $validatedData['user_id'] = JWTAuth::user()->id;
        $employer = Employer::create($validatedData);

        $path = $this->file_service->uploadFile($request, 'company_logo' , 'companies');

        $file = $this->file_service->store($path, 'company_logo' , $employer->id , Employer::class);
        if (!$file) {
            return null;
        }
        return $employer;
    }

    /**
     * @throws \Exception
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate(Employer::rules());
        $Employer = Employer::where('user_id', JWTAuth::user()->id)->get()->first();

        $path = $this->file_service->uploadFile($request, 'company_logo' , 'companies');

        $file = $this->file_service->store($path, 'company_logo' , $Employer->id , Employer::class);
        if (!$file) {
            return null;
        }
        $Employer->update($validatedData);
        return $Employer;
    }

    public function destroy($id): bool
    {
        $Employer = Employer::find($id);
        File::where('fileable_id' , $id)->delete();
        if($Employer){
            $Employer->delete();
            return true;
        }
        return false;
    }

    public function show($id)
    {
        $Employer = Employer::where('id' , $id)->get()->first();
        $Employer['company_logo'] = File::where('fileable_id' , $Employer->id)->get()->first()->path;
        if($Employer){
            return $Employer;
        }
        return false;
    }
}
