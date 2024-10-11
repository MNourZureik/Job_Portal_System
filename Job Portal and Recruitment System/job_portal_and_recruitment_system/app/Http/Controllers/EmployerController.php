<?php

namespace App\Http\Controllers;

use App\Services\EmployerService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployerController extends Controller
{
    protected EmployerService $employer_service;
    public function __construct()
    {
        $this->employer_service = new EmployerService();
    }

    /**
     * @throws \Exception
     */
    public function store(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $admin = $this->employer_service->store($request);
        if ($admin) {
            return $this->handleResponse($admin , 'registered successfully' , 201);
        }
        return $this->handleResponse(null , 'unable to register' , 500);
    }

    public function show($id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $admin = $this->employer_service->show($id);
        if ($admin) {
            return $this->handleResponse($admin , 'show successfully' , 200);
        }
        return $this->handleResponse(null , 'unable to show' , 500);
    }

    /**
     * @throws \Exception
     */
    public function update(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $admin = $this->employer_service->update($request);
        if ($admin) {
            return $this->handleResponse($admin , 'updated successfully' , 200);
        }
        return $this->handleResponse(null , 'unable to update' , 500);
    }

    public function destroy($id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $admin = $this->employer_service->destroy($id);
        if ($admin) {
            return $this->handleResponse(null, 'deleted successfully' , 200);
        }
        return $this->handleResponse(null , 'unable to delete' , 500);
    }
}
