<?php

namespace Sina\Shuttle;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Sina\Shuttle\Console\InstallShuttlePackage;
use Sina\Shuttle\View\Breadcrumb;
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
            Breadcrumb::class
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/Resources/Assets' => public_path('shuttle'),
            ], 'assets');

            $this->publishes([
                __DIR__.'/Resources/Views' => resource_path('views/vendor/shuttle'),
            ], 'views');

            $this->publishes([
                __DIR__.'/Resources/Views/index.blade.php' => resource_path('views/index.blade.php'),
                __DIR__.'/Resources/Views/app.blade.php' => resource_path('views/app.blade.php'),
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
