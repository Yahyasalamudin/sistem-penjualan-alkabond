<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Sales;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });

        Route::bind('user', function ($value) {
            $id = Hashids::decode($value);
            if (count($id) === 0) {
                abort(404);
            }

            return User::findOrFail($id[0]);
        });

        Route::bind('sales', function ($value) {
            $id = Hashids::decode($value);
            if (count($id) === 0) {
                abort(404);
            }

            return Sales::findOrFail($id[0]);
        });

        Route::bind('store', function ($value) {
            $id = Hashids::decode($value);
            if (count($id) === 0) {
                abort(404);
            }

            return Store::findOrFail($id[0]);
        });

        Route::bind('transaction', function ($value) {
            $id = Hashids::decode($value);
            if (count($id) === 0) {
                abort(404);
            }

            return Transaction::findOrFail($id[0]);
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
