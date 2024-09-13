<?php

namespace App\Http\Middleware;

use App\Models\Facility;
use App\Models\FacilityAdmin;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
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
        if($request->user()->role->name === config('constants.roles.admin')){
            $facilityIds = FacilityAdmin::where(['admin_id' => $request->user()->id])->get()->pluck('facility_id')->toArray();
            $request->mergeIfMissing(['associated_facility_ids' => $facilityIds]);
            return $next($request);
        }
        abort(403);
    }
}
