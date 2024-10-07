<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller as Controller;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JobSeekerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the required role using Spatie
        if ($request->user()->role != 'job_seeker') {
            return (new Controller)->handleResponse(null , 'Unauthorized' , 403);
        }
        return $next($request);
    }
}
