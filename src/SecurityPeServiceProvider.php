<?php

namespace Jhonhdev\SecurityPe;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Jhonhdev\SecurityPe\Http\Controllers\SecurityPeController;
use Jhonhdev\SecurityPe\Http\Middleware\ActivityUserRequest;
use Jhonhdev\SecurityPe\Models\Schemas\Security\PersonalAccessTokens;
use Laravel\Sanctum\Sanctum;

class SecurityPeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        if (! app()->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/securitype.php', 'securitype');
        }

        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        if (app()->runningInConsole()) {
            $this->registerMigrations();
            if (config('securitype.only_bridge', false) === false) {
                $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'securitype-migrations');
            }

            $this->publishes([__DIR__.'/../config/securitype.php' => config_path('securitype.php')], 'securitype-config');
        }

        $this->defineRoutes();
        $this->configureMiddleware();
        Sanctum::usePersonalAccessTokenModel(PersonalAccessTokens::class);
    }

    /**
     * Register SecurityPe's migration files.
     *
     * @return void
     */
    protected function registerMigrations() {
        if (SecurityPe::shouldRunMigrations()) {
            return $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    /**
     * Define the SecurityPe routes.
     *
     * @return void
     */
    protected function defineRoutes() {
        if (app()->routesAreCached() || config('securitype.routes') === false) { 
            return; 
        }
        
        Route::group(['prefix' => config('securitype.prefix', 'securitype')], function () {
            Route::post('/auth/login', SecurityPeController::class.'@authentication')->middleware('api')->name('securitype.login');
            Route::get('/auth/logout', SecurityPeController::class.'@unauthentication')->middleware('auth:sanctum')->name('securitype.signout');
            Route::post('/auth/validatetoken', SecurityPeController::class.'@validateToken')->middleware('auth:sanctum')->name('securitype.validatetoken');
        });
    }

    /**
     * Configure the SecurityPe middleware and priority.
     *
     * @return void
     */
    protected function configureMiddleware() {
        $kernel = app()->make(Kernel::class);

        $kernel->prependToMiddlewarePriority(ActivityUserRequest::class);
    }
}
