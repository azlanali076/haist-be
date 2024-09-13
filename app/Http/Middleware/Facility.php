<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Facility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->facility_id) {
            $request->mergeIfMissing(['facility_id' => $request->user()->facility_id]);
            return $next($request);
        }
        abort(400,"Not associated with any Facility");
    }
}
