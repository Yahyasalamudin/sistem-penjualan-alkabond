<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PageCacheMiddleware
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
        if ($request->isMethod('get')) {
            $cacheKey = 'page_' . $request->url();

            if (Cache::has($cacheKey)) {
                $cachedResponse = Cache::get($cacheKey);
                return response($cachedResponse);
            }

            $response = $next($request);

            if ($response->getStatusCode() == 200) {
                Cache::put($cacheKey, $response->getContent(), now()->addMinutes(10));
            }

            return $response;
        }

        return $next($request);
    }
}
