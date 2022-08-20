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
use Sina\Shuttle\Console\ComponentMakeCommand;
use Sina\Shuttle\Console\InstallShuttlePackage;
use Sina\Shuttle\Models\Admin;
use Sina\Shuttle\Models\Menu as ModelsMenu;
use Sina\Shuttle\View\Breadcrumb;
use Sina\Shuttle\View\Form;
use Sina\Shuttle\View\Menu;
use Sina\Shuttle\View\DynamicComponent;
use Sina\Shuttle\View\Table;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
use Sina\Shuttle\FormBuilder\FormBuilder;
use Sina\Shuttle\FormBuilder\HtmlBuilder;

class ShuttleServiceProvider extends ServiceProvider
{
    /**
     * Supported Blade Directives
     *
     * @var array
     */
    protected $directives = [
        'entities', 'decode', 'script', 'style', 'image', 'favicon', 'link', 'secureLink', 'linkAsset', 'linkSecureAsset', 'linkRoute', 'linkAction', 'mailto', 'email', 'ol', 'ul', 'dl', 'meta', 'tag', 'open', 'model', 'close', 'token', 'label', 'input', 'text', 'password', 'hidden', 'email', 'tel', 'number', 'date', 'datetime', 'datetimeLocal', 'time', 'url', 'file', 'textarea', 'select', 'selectRange', 'selectYear', 'selectMonth', 'getSelectOption', 'checkbox', 'radio', 'reset', 'image', 'color', 'submit', 'button', 'old'
    ];

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

        $this->app->bind('shuttle', function ($app) {
            return new Shuttle();
        });

        $this->registerHtmlBuilder();

        $this->registerFormBuilder();

        $this->app->alias('html', HtmlBuilder::class);
        $this->app->alias('form', FormBuilder::class);

        $this->registerBladeDirectives();
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
            Form::class,
            DynamicComponent::class,
            Table::class
        ]);

        if ($this->app->runningInConsole()) {
            // $this->publishes([
            //     __DIR__.'/Resources/Assets' => public_path('shuttle'),
            // ], 'assets');

            // $this->publishes([
            //     __DIR__.'/Resources/Views' => resource_path('views/vendor/shuttle'),
            // ], 'views');

            $this->publishes([
                __DIR__ . '/../resources/views/index.blade.php' => resource_path('views/index.blade.php'),
                __DIR__ . '/../resources/views/app.blade.php' => resource_path('views/app.blade.php'),
            ], 'app');

            $this->commands([
                InstallShuttlePackage::class,
                ComponentMakeCommand::class
            ]);
        }

        View::composer('shuttle::admin', function ($view) {
            $menus = ModelsMenu::where('name', 'shuttle_menu')->first();
            $view
                ->with('scaffold', \Sina\Shuttle\Models\ScaffoldInterface::all())
                ->with('menus', $menus ? $menus->items()->get()->append(['label', 'link']) : null);
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

        Gate::define('developer', function ($user) {
            return $user->role == 'developer';
        });
    }

    protected function registerRoutes()
    {
        Route::name('shuttle.')->middleware('web')->namespace('Sina\Shuttle\Http\Controllers')->prefix("mygo")->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/routes.php');
        });
    }

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerHtmlBuilder()
    {
        $this->app->singleton('html', function ($app) {
            return new HtmlBuilder($app['url'], $app['view']);
        });
    }

    /**
     * Register the form builder instance.
     *
     * @return void
     */
    protected function registerFormBuilder()
    {
        $this->app->singleton('form', function ($app) {
            $form = new FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->token(), $app['request']);

            return $form->setSessionStore($app['session.store']);
        });
    }

    /**
     * Register Blade directives.
     *
     * @return void
     */
    protected function registerBladeDirectives()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $namespaces = [
                'Html' => get_class_methods(HtmlBuilder::class),
                'Form' => get_class_methods(FormBuilder::class),
            ];

            foreach ($namespaces as $namespace => $methods) {
                foreach ($methods as $method) {
                    if (in_array($method, $this->directives)) {
                        $snakeMethod = Str::snake($method);
                        $directive = strtolower($namespace) . '_' . $snakeMethod;

                        $bladeCompiler->directive($directive, function ($expression) use ($namespace, $method) {
                            return "<?php echo $namespace::$method($expression); ?>";
                        });
                    }
                }
            }
        });
    }

    protected function loadHelpers()
    {
        require_once __DIR__ . '/helpers.php';
    }
}
