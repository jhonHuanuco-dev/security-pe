<?php

namespace Jhonhdev\SecurityPe\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jhonhdev\SecurityPe\Models\Schemas\Security\Activity;
use Jhonhdev\SecurityPe\SecurityPe;
use Symfony\Component\HttpFoundation\Response;

class ActivityUserRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('sanctum')->check()) {
            if (!str_contains($request->url(), 'validatetoken')) {
                $ip_address = SecurityPe::ipAddress($request);
                
                Activity::create([
                    'user_id' => Auth::guard('sanctum')->user()->id,
                    'url' => $request->url(),
                    'user_agent' => $request->header('User-Agent'),
                    'method' => $request->method(),
                    'ip_address' => $ip_address,
                ]);
            }
        }
        
        return $next($request);
    }
}
