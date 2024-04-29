<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseStatusCodes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next, $role): Response
    // {
    //     // if (!in_array($request->user()->role, $roles)) {
    //     //     return errorResponse(ResponseStatusCodes::UNAUTHORIZED, "Unauthorized Access", [], Response::HTTP_UNAUTHORIZED);
    //     // }
    //     // return $next($request);

    //     if (Auth::check() && Auth::user()->role == $role) {
    //         return $next($request);
    //     }
    //     return errorResponse(ResponseStatusCodes::UNAUTHORIZED, "Unauthorized Access", [], Response::HTTP_UNAUTHORIZED);
    // }

    public function handle(Request $request, Closure $next, $role): Response
    {
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }
        return errorResponse(ResponseStatusCodes::UNAUTHORIZED, "Unauthorized Access", [], Response::HTTP_UNAUTHORIZED);
    }
}
