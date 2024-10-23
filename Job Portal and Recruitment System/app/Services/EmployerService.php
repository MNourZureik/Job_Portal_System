<?php

namespace App\Services;

use App\Models\File;
use App\Models\users\Employer;
use App\Services\helping_services\FileService;
use App\Traits\GlobalFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class EmployerService
{
    protected FileService $file_service;

    use GlobalFunctions;
    public function __construct()
    {
        $this->file_service = new FileService();
    }

    /**
     * @throws \Exception
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $validatedData = $request->validate(Employer::rules());
            $validatedData['user_id'] = JWTAuth::user()->id;
            $employer = Employer::create($validatedData);

            $path = $this->file_service->uploadFile($request, 'company_logo', 'companies');

            $file = $this->file_service->store($path, 'company_logo', $employer->id, Employer::class);
            if (!$file) {
                return null;
            }

//            $coordinates = $this->geocodeAddress($employer->company_address);
//            dd($coordinates);
//            if ($coordinates) {
//                $employer->latitude = $coordinates['lat'];
//                $employer->longitude = $coordinates['lng'];
//            } else {
//                return null;
//            }
//            $employer->save();
            DB::commit();
            return $employer;
        }catch (\Exception $exception){
            DB::rollBack();
            return null;
        }
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

    public function show($id): bool
    {
        $Employer = Employer::where('id' , $id)->get()->first();
        $Employer['company_logo'] = File::where('fileable_id' , $Employer->id)->get()->first()->path;
        if($Employer){
            return $Employer;
        }
        return false;
    }
}
