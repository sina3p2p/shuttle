<?php

namespace Sina\Shuttle;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportUserProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Sina\Shuttle\Console\InstallShuttlePackage;
use Sina\Shuttle\Models\Admin;
use Sina\Shuttle\View\Breadcrumb;
use Sina\Shuttle\View\Form;
use Sina\Shuttle\View\Menu;

class ShuttleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/shuttle.php',
            'shuttle'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/setting.php',
            'setting'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/view.php',
            'eloquent-viewable'
        );

        $this->loadHelpers();

        $this->app->bind('shuttle', function($app) {
            return new Shuttle();
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->registerRoutes();
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'shuttle');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->loadViewComponentsAs('shuttle', [
            Menu::class,
            Breadcrumb::class,
            Form::class
        ]);

        if ($this->app->runningInConsole()) {
            // $this->publishes([
            //     __DIR__.'/Resources/Assets' => public_path('shuttle'),
            // ], 'assets');

            // $this->publishes([
            //     __DIR__.'/Resources/Views' => resource_path('views/vendor/shuttle'),
            // ], 'views');

            $this->publishes([
                __DIR__.'/../resources/views/index.blade.php' => resource_path('views/index.blade.php'),
                __DIR__.'/../resources/views/app.blade.php' => resource_path('views/app.blade.php'),
            ], 'app');

            $this->commands([
                InstallShuttlePackage::class,
            ]);
        }

        View::composer('shuttle::admin', function ($view) {
            $view->with('scaffold',\Sina\Shuttle\Models\ScaffoldInterface::all());
        });

        View::composer('app', function ($view) {
            $view->with('setting', setting()->all())->with('lang', LaravelLocalization::getCurrentLocale());
        });

        Config::set('auth.guards.shuttle', [
            'driver' => 'session',
            'provider' => 'shuttle',
        ]);
        
        Config::set('auth.guards.shuttle_api', [
            'driver' => 'token',
            'provider' => 'shuttle',
            // 'hash' => true,
        ]);

        Config::set('auth.providers.shuttle', [
            'driver' => 'eloquent',
            'model' => Admin::class,
        ]); 
        
        // Config::set('auth.providers.shuttle_api', [
        //     'driver' => 'eloquent',
        //     'model' => Admin::class,
        // ]);

        Gate::define('developer', function($user) {
            return $user->role == 'developer';
        });

    }

    protected function registerRoutes()
    {
        Route::name('shuttle.')->middleware('web')->namespace('Sina\Shuttle\Http\Controllers')->prefix("mygo")->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/routes.php');
        });
    }

    protected function loadHelpers()
    {
        require_once __DIR__.'/helpers.php';
    }
}
