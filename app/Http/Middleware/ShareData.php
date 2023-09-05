<?php

namespace App\Http\Middleware;

use App\Models\City;
use App\Models\CityBranch;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareData
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
        if (!Auth::check()) {
            $cities = City::get();
            $city_branches_topbar = CityBranch::get();
            view()->share(['cities' => $cities, 'city_branches_topbar' => $city_branches_topbar]);
        }

        return $next($request);
    }
}
