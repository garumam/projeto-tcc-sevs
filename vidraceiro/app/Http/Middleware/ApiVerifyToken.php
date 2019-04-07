<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
class ApiVerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()){
            if (Carbon::parse($request->user()->token()->expires_at) < Carbon::now()) {
                $request->user()->token()->revoke();
                $request->user()->token()->delete();
                return response()->json(['error'], 401);
            }
        }
       
        return $next($request);
    }
}
