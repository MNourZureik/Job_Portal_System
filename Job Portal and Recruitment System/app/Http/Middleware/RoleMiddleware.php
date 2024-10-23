<?php /** @noinspection ALL */

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
                $controller = new Controller();
                $user = JWTAuth::user();

                if ($user) {

                    $prefix = $request->route()->getPrefix();
                    $prefixParts = explode('/', trim($prefix, '/'));
                    $lastPrefix = strtolower(end($prefixParts));

                    if ($lastPrefix === strtolower($user->role)) {
                        return $next($request);
                    }
                }
                return $controller->handleResponse(null , 'Unauthorized' , Response::HTTP_UNAUTHORIZED);

    }
}
