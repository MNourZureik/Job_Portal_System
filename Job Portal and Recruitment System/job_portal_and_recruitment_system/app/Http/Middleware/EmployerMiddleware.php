<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class EmployerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the required role using Spatie
        if ($request->user()->role != 'employer') {
            return (new Controller)->handleResponse(null , 'Unauthorized' , 403);
        }
        return $next($request);
    }
}
