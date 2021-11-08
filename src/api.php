<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Sina\Shuttle\Http\Controllers\AdminController;
use Sina\Shuttle\Http\Controllers\Api\ApiDashboardController;
use Sina\Shuttle\Http\Controllers\AuthController;
use Sina\Shuttle\Http\Controllers\ComponentController;
use Sina\Shuttle\Http\Controllers\DashboardController;
use Sina\Shuttle\Http\Controllers\HomeController;
use Sina\Shuttle\Http\Controllers\MediaController;
use Sina\Shuttle\Http\Controllers\MenuController;
use Sina\Shuttle\Http\Controllers\PageController;
use Sina\Shuttle\Http\Controllers\ScaffoldController;
use Sina\Shuttle\Http\Controllers\SectionController;
use Sina\Shuttle\Http\Middleware\ShuttleAdminMiddleware;

Route::name('api.shuttle.')->group(function () {

    Route::prefix('mypanel')->group(function () {

        Route::get('shuttle', [DashboardController::class, 'shuttle']);

        Route::get('login', ['as' => 'login' , 'uses' => 'AuthController@index']);
        Route::post('login', [AuthController::class, 'store'])->name('login.store');
        Route::view('forget-password', 'shuttle::auth.forget')->name('forget');

        Route::middleware([ShuttleAdminMiddleware::class])->group(function (){

            Route::get('/user', [AdminController::class, 'user']);

            Route::get('logout',function (){
                Auth::logout();
                return redirect()->route('shuttle.login');
            });

            Route::get('/', ['as' => 'index', 'uses' => 'DashboardController@index']);
            Route::post('/analytics', ['as' => 'analytics', 'uses' => 'DashboardController@show']);

            Route::resource('roles','RoleController');

            Route::get('database/model', 'DatabaseController@myShow')->name('database.bymodel');
            Route::resource('database', 'DatabaseController');

            Route::resource('translation', 'TranslationController')->except(['show']);

            Route::get('menu',[MenuController::class, 'index'])->name('menu.index');
            Route::get('menu/create',[MenuController::class, 'create'])->name('menu.create');
            Route::post('menu',[MenuController::class, 'store'])->name('menu.store');
            Route::get('menu/{menu}/edit',[MenuController::class, 'edit'])->name('menu.edit');
            Route::put('menu/{menu}',[MenuController::class, 'update'])->name('menu.update');
            // Route::resource('menu','MenuController');


            Route::put('menu/items/{menu_item}',['as' => 'menuItem.update', 'uses' => 'MenuController@itemsUpdate']);
            Route::delete('menu/items/{menu_item}',['as' => 'menu.delete', 'uses' => 'MenuController@itemsDestroy']);
            Route::post('menu/sort',['as' => 'menu.sort', 'uses' => 'MenuController@sort']);

            Route::resource('setting','SettingController')->only('index','store');
            Route::post('setting/admin','SettingController@changePassword')->name('change_password');

            Route::group([
                'as'     => 'bread.',
                'prefix' => 'bread',
            ], function () {
                Route::get('/', ['uses' => 'BreadController@index', 'as' => 'index']);
                Route::get('{table}/create', ['uses' => 'BreadController@create', 'as' => 'create']);
                Route::post('/', ['uses' => 'BreadController@store', 'as' => 'store']);
                Route::get('{scaffold_interface:name}/edit', ['uses' => 'BreadController@edit', 'as' => 'edit']);
                Route::put('{scaffold_interface}', ['uses' => 'BreadController@update', 'as' => 'update']);
                Route::delete('{id}', ['uses' => 'BreadController@destroy', 'as' => 'delete']);
                Route::post('{scaffold_interface:name}/relationship', ['uses' =>'BreadController@addRelationship', 'as' => 'relationship']);
                Route::get('delete_relationship/{id}', ['uses' => 'BreadController@deleteRelationship', 'as' => 'delete_relationship']);
            });

            Route::get('/js/{section}/components', ['as' => 'component.js', 'uses' => 'ComponentController@jsData']);
            Route::get('/js/{model}', ['as' => 'model.js.data', 'uses' => 'ScaffoldController@jsData']);
            Route::post('page',[PageController::class, 'store'])->name('page.store');
            Route::get('page/create',[PageController::class, 'create'])->name('page.create');
            Route::get('page/{page}/edit',[PageController::class, 'edit'])->name('page.edit');
            Route::put('page/{page}',[PageController::class, 'update'])->name('page.update');
            Route::get('page/component',[SectionController::class, 'componentAdd'])->name('user_component_store');
            Route::get('page/component/{page_component}',[PageController::class, 'componentEditor'])->name('user_component');
            // Route::post('page/component/{page_component}',[PageController::class, 'componentSave']);
            Route::post('page/component/{page_component}',[PageController::class, 'componentSave2']);
            Route::delete('page/component/{page_component}/delete', [SectionController::class, 'componentRemove'])->name('user_component.delete');
            Route::post('section/{section}/component', ['as' => 'section.component', 'uses' => 'SectionController@sectionComponentUpdate']);
            Route::put('section/{section}/user', ['as' => 'section.user', 'uses' => 'SectionController@userUpdate']);
            Route::post('component/sort','SectionController@sort')->name('component.sort');
            Route::get('component',[ComponentController::class, 'index'])->name('component.index');
            // Route::store('component','ComponentController');
            // Route::put('component','ComponentController');
            // Route::delete('component','ComponentController');
            Route::resource('type','TypeController');

            Route::group([
                'as'     => 'section.',
                'prefix' => 'section',
            ], function () {
                Route::post('{type}', ['uses' => 'SectionController@store', 'as' => 'store']);
                Route::put('{section}', ['uses' => 'SectionController@update', 'as' => 'update']);
            });

            Route::group([
                'as'     => 'media.',
                'prefix' => 'media',
            ], function () {
    //        Route::get('/', ['uses' => 'VoyagerMediaController@index', 'as' => 'index']);
    //        Route::post('files', ['uses' => $namespacePrefix.'VoyagerMediaController@files',              'as' => 'files']);
    //        Route::post('new_folder', ['uses' => $namespacePrefix.'VoyagerMediaController@new_folder',         'as' => 'new_folder']);
    //        Route::post('delete_file_folder', ['uses' => $namespacePrefix.'VoyagerMediaController@delete', 'as' => 'delete']);
    //        Route::post('move_file', ['uses' => $namespacePrefix.'VoyagerMediaController@move',          'as' => 'move']);
    //        Route::post('rename_file', ['uses' => $namespacePrefix.'VoyagerMediaController@rename',        'as' => 'rename']);
                Route::get('link',   [MediaController::class, 'link'])->name('link');
                Route::post('upload', [MediaController::class, 'upload'])->name('upload');
    //        Route::post('crop', ['uses' => $namespacePrefix.'VoyagerMediaController@crop',             'as' => 'crop']);
            });

            Route::group([
                'as'     => 'scaffold_interface.',
            ], function () {
                Route::get('{scaffold_interface:slug}/init',         [ScaffoldController::class,    'rows'])->name('init');
                Route::get('{scaffold_interface:slug}/relationship', ['uses' =>'ScaffoldController@relationship', 'as' => 'relationship']);
                Route::get('scaffold_interface/load_relationship',   [ScaffoldController::class,  'loadRelationship']);
                Route::get('{scaffold_interface:slug}',              [ScaffoldController::class,   'index'])->name('index');
                Route::get('{scaffold_interface:slug}/create',       [ScaffoldController::class,  'create'])->name('create');
                Route::post('{scaffold_interface:slug}',             [ScaffoldController::class,   'store'])->name('store');
                Route::get('{scaffold_interface:slug}/{id}/edit',    [ScaffoldController::class,    'edit'])->name('edit');
                Route::put('{scaffold_interface:slug}/{id}',         [ScaffoldController::class,  'update'])->name('update');
                Route::delete('{scaffold_interface:slug}/{id}',      [ScaffoldController::class, 'destroy'])->name('destroy');
                Route::get('{scaffold_interface:slug}/{id}', ['uses' => 'ScaffoldController@show', 'as' => 'show']);
                Route::get('delete_relationship/{id}', ['uses' => 'ScaffoldController@deleteRelationship', 'as' => 'delete_relationship']);
                Route::post('{scaffold_interface:slug}/sort', ['uses' => 'ScaffoldController@sort', 'as' => 'sort']);
            });

    //    Route::resource('{scaffold_interface:slug}', 'ScaffoldController');

    //    Route::group([
    //        'as'     => 'bread.',
    //        'prefix' => 'bread',
    //    ], function () {
    //        Route::get('/', ['uses' => 'BreadController@index', 'as' => 'index']);
    //        Route::get('{table}/create', ['uses' => 'BreadController@create', 'as' => 'create']);
    //        Route::post('/', ['uses' => 'BreadController@store', 'as' => 'store']);
    //        Route::get('{table}/edit', ['uses' => 'BreadController@edit', 'as' => 'edit']);
    //        Route::put('{id}', ['uses' => 'BreadController@update', 'as' => 'update']);
    //        Route::delete('{id}', ['uses' => 'BreadController@destroy', 'as' => 'delete']);
    //        Route::post('relationship', ['uses' =>'BreadController@addRelationship', 'as' => 'relationship']);
    //        Route::get('delete_relationship/{id}', ['uses' => 'BreadController@deleteRelationship', 'as' => 'delete_relationship']);
    //    });
        });
    });


    Route::get('component/{page_component}', [ComponentController::class, 'show']);

    Route::get('media/link',   [MediaController::class, 'link']);

    Route::prefix(LaravelLocalization::setLocale())->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])->group(function () {
        Route::post('contact', 'HomeController@contact');
        Route::get('/', 'HomeController@index');
        try {
            foreach (\Sina\Shuttle\Models\Page::all() as $page){
                Route::get($page->url.'/{slug?}', [HomeController::class, 'index'])->where('slug', '.*');
            }
        }catch (\Exception $exception){}
    });
});


