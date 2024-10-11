<?php

namespace App\Services\helper_services;

use App\Models\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileService
{
    /**
     * @throws \Exception
     */
    private function storeFile($file, $directory)
    {
        try{
            return $file->storeAs($directory, $file->getClientOriginalName());
        }
        catch (\Exception $exception){
            Log::error('File Upload Error: '.$exception->getMessage());
            throw new \Exception('Error uploading file');
        }
    }

    public function downloadFile($filePath): ?BinaryFileResponse
    {
        if (Storage::exists($filePath)) {
            return response()->download(storage_path($filePath));
        }
        return null;
    }

    public function deleteFile($filePath): ?bool
    {
        if (Storage::exists($filePath)) {
            return Storage::delete($filePath);
        }
        return null;
    }

    public function getFileSize($filePath): ?int
    {
        if (Storage::exists($filePath)) {
            return Storage::size($filePath);
        }
        return null;
    }

    public function getFileMimeType($filePath): bool|string|null
    {
        if (Storage::exists($filePath)) {
            return Storage::mimeType($filePath);
        }
        return null;
    }
    public function listFiles($directory): array
    {
        return Storage::files($directory);
    }

    public function fileExists($file): bool
    {
        return Storage::exists($file);
    }

    public function createDirectory($directory): ?bool
    {
        if (!Storage::exists($directory)) {
            return Storage::makeDirectory($directory);
        }
        return null;
    }

    public function deleteDirectory($directory): ?bool
    {
        if (Storage::exists($directory)) {
            return Storage::deleteDirectory($directory);
        }
        return null;
    }

    public function getFileUrl($filePath): ?string
    {
        if (Storage::exists($filePath)) {
            return Storage::url($filePath);
        }
        return null; // File not found
    }

    /**
     * @throws \Exception
     */
    public function uploadFile($request , $fileName , $directory)
    {
        if ($request->hasFile($fileName)) {
            $file = $request->file($fileName);

            $fileName = $file->getClientOriginalName();
            $filePath = $directory . '/' . $fileName;

            $this->deleteFile($filePath);

            return $this->storeFile($file, $directory);
        }
        return null;
    }

    /**
     * @throws \Exception
     */
    public function validateFile($file, $allowedMimeTypes = ['image/jpeg', 'image/png' , 'image/jpg'], $maxSize = 2): void
    {
        if (!in_array(($file->getMimeType()), $allowedMimeTypes)) {
            throw new \Exception("File type not allowed");
        }

        if (($file->getSize()) > $maxSize * 1024) { // Convert KB to bytes
            throw new \Exception("File size exceeds the limit");
        }
    }

    /**
     * @throws \Exception
     */
    public function uploadMultipleFiles($request , array $files, $directory): array
    {
        $uploadedFiles = [];
        foreach ($files as $file) {
            $uploadedFiles[] = $this->uploadFile( $request, $file, $directory);
        }
        return $uploadedFiles;
    }

    public function store($path , $name , $fileable_id , $fileable_type)
    {
        if($path){
            $file = File::where('path' , $path)->get()->first();
            if ($file) {
                if($fileable_id === $file->fileable_id){
                    $file->forceDelete();
                }
            }
            return File::create(
                [
                    'name' => $name,
                    'path' => $path,
                    'fileable_id' => $fileable_id,
                    'fileable_type' => $fileable_type,
                ]
            );
        }
        return null;

    }

}
