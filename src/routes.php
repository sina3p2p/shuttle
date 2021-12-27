<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Sina\Shuttle\Http\Controllers\AuthController;
use Sina\Shuttle\Http\Controllers\ComponentController;
use Sina\Shuttle\Http\Controllers\DashboardController;
use Sina\Shuttle\Http\Controllers\Developer\BreadController;
use Sina\Shuttle\Http\Controllers\Developer\DatabaseController;
use Sina\Shuttle\Http\Controllers\Developer\MenuController as DeveloperMenuController;
use Sina\Shuttle\Http\Controllers\HomeController;
use Sina\Shuttle\Http\Controllers\MediaController;
use Sina\Shuttle\Http\Controllers\MenuController;
use Sina\Shuttle\Http\Controllers\PageController;
use Sina\Shuttle\Http\Controllers\ScaffoldController;
use Sina\Shuttle\Http\Controllers\SectionController;
use Sina\Shuttle\Http\Controllers\SettingController;
use Sina\Shuttle\Http\Controllers\TypeController;

Route::name('shuttle.')->group(function () {

    Route::get('shuttle-assets/{fileName}', [DashboardController::class, 'assets'])->name('assets')->where('fileName', '.*');

    Route::prefix('mypanel')->group(function () {

        Route::get('login',  [AuthController::class, 'index'])->name('login');
        Route::post('login', [AuthController::class, 'store'])->name('login.store');
        Route::view('forget-password', 'shuttle::auth.forget')->name('forget');

        Route::middleware('auth:shuttle')->group(function (){

            Route::get('logout',function (){
                Auth::logout();
                return redirect()->route('shuttle.login');
            });


            Route::prefix('developer')->name('developer.')->group(function () {

                Route::group([
                    'as'     => 'bread.',
                    'prefix' => 'bread',
                ], function () {
                    Route::get('/',                                         [BreadController::class,              'index'])->name('index');
                    Route::get('{table}/create',                            [BreadController::class,             'create'])->name('create');
                    Route::post('/',                                        [BreadController::class,              'store'])->name('store');
                    Route::get('{scaffold_interface:name}/edit',            [BreadController::class,               'edit'])->name('edit');
                    Route::put('{scaffold_interface}',                      [BreadController::class,             'update'])->name('update');
                    Route::delete('{id}',                                   [BreadController::class,            'destroy'])->name('delete');
                    Route::post('{scaffold_interface:name}/relationship',   [BreadController::class,    'addRelationship'])->name('relationship');
                    Route::get('delete_relationship/{id}',                  [BreadController::class, 'deleteRelationship'])->name('delete_relationship');
                });

                Route::get('menu', [DeveloperMenuController::class, 'index'])->name('menu.index');
        
                Route::resource('database', DatabaseController::class);

                Route::resource('type', TypeController::class);

            });

            Route::get('/', [DashboardController::class, 'index'])->name('index');
            Route::post('/analytics', ['as' => 'analytics', 'uses' => 'DashboardController@show']);

            Route::resource('roles','RoleController');

            Route::get('database/model', [DatabaseController::class, 'myShow'])->name('database.bymodel');

            Route::resource('translation', 'TranslationController')->except(['show']);

            Route::resource('menu', MenuController::class);
            Route::put('menu/items/{menu_item}',[ MenuController::class, 'itemsUpdate'])->name('menuItem.update');
            Route::delete('menu/items/{menu_item}',[MenuController::class, 'itemsDestroy'])->name('menu.delete');
            Route::post('menu/sort',[ MenuController::class, 'sort'])->name('menu.sort');

            Route::resource('setting', SettingController::class)->only('index','store');
            Route::post('setting/admin','SettingController@changePassword')->name('change_password');
            
            Route::get('/js/{section}/components', ['as' => 'component.js', 'uses' => 'ComponentController@jsData']);
            Route::get('/js/{model}', [ ScaffoldController::class, 'jsData'])->name('model.js.data');
            Route::resource('page', PageController::class)->except('show');
            Route::get('page/component',[SectionController::class, 'componentAdd'])->name('user_component_store');
            Route::get('page/component/{page_component}',[PageController::class, 'componentEditor'])->name('user_component');
            Route::post('page/component/{page_component}',[PageController::class, 'componentSave']);
            Route::delete('page/component/{page_component}/delete', [SectionController::class, 'componentRemove'])->name('user_component.delete');
            Route::post('section/{section}/component', ['as' => 'section.component', 'uses' => 'SectionController@sectionComponentUpdate']);
            Route::put('section/{section}/user', ['as' => 'section.user', 'uses' => 'SectionController@userUpdate']);
            Route::post('component/sort',[SectionController::class, 'sort'])->name('component.sort');
            Route::resource('component',ComponentController::class);

            Route::group([
                'as'     => 'section.',
                'prefix' => 'section',
            ], function () {
                Route::post('{type}', [SectionController::class, 'store'])->name('store');
                Route::put('{section}',  [SectionController::class, 'update'])->name('update');
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
                Route::post('upload', [MediaController::class, 'upload'])->name('upload');
    //        Route::post('crop', ['uses' => $namespacePrefix.'VoyagerMediaController@crop',             'as' => 'crop']);
            });

            Route::group([
                'as'     => 'scaffold_interface.',
            ], function () {
                Route::get('{scaffold_interface_row}/array',         [ScaffoldController::class,        'array'])->name('array');
                Route::get('{scaffold_interface_row}/relationship',  [ScaffoldController::class, 'relationship'])->name('relationship');
                Route::get('{scaffold_interface:slug}',              [ScaffoldController::class,        'index'])->name('index');
                Route::get('{scaffold_interface:slug}/create',       [ScaffoldController::class,       'create'])->name('create');
                Route::post('{scaffold_interface:slug}',             [ScaffoldController::class,        'store'])->name('store');
                Route::get('{scaffold_interface:slug}/{id}/edit',    [ScaffoldController::class,         'edit'])->name('edit');
                Route::put('{scaffold_interface:slug}/{id}',         [ScaffoldController::class,       'update'])->name('update');
                Route::delete('{scaffold_interface:slug}/{id}',      [ScaffoldController::class,      'destroy'])->name('destroy');
                Route::get('{scaffold_interface:slug}/{id}',         [ScaffoldController::class,         'show'])->name('show');
                Route::post('{scaffold_interface:slug}/sort',        [ScaffoldController::class,         'sort'])->name('sort');
                Route::get('delete_relationship/{id}',               [ScaffoldController::class, 'deleteRelationship'])->name('delete_relationship');
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

    Route::prefix(LaravelLocalization::setLocale())->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])->group(function () {
        Route::post('contact', 'HomeController@contact');
        Route::get('/', [HomeController::class, 'index']);
        try {
            foreach (\Sina\Shuttle\Models\Page::all() as $page){
                Route::get($page->url.'/{slug?}', [HomeController::class, 'index'])->where('slug', '.*');
            }
        }catch (\Exception $exception){}
    });
});
