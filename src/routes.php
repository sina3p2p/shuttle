<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::name('shuttle.')->namespace('Sina\Shuttle\Http\Controllers')->group(function () {

    Route::get('shuttle-assets/{fileName}', ['uses' => 'DashboardController@assets', 'as' => 'assets'])->where('fileName', '.*');

    Route::prefix('mygo')->group(function () {

        Route::get('login', ['as' => 'login' , 'uses' => 'AuthController@index']);
        Route::post('login', ['as' => 'login.store' , 'uses' => 'AuthController@store']);
        Route::view('forget-password', 'shuttle::auth.forget')->name('forget');

        Route::middleware('auth:admin')->group(function (){

            Route::get('logout',function (){
                Auth::logout();
                return redirect()->route('shuttle.login');
            });

            Route::get('/', ['as' => 'index', 'uses' => 'DashboardController@index']);
            Route::post('/analytics', ['as' => 'analytics', 'uses' => 'DashboardController@show']);


            Route::get('module/import', ['uses' => 'ModuleController@import', 'as' => 'module.import']);
            Route::post('module/post',   ['uses' => 'ModuleController@store', 'as' => 'module.store']);

            Route::resource('roles','RoleController');

            Route::get('database/model', 'DatabaseController@myShow')->name('database.bymodel');
            Route::resource('database', 'DatabaseController');

            Route::resource('translation', 'TranslationController')->except(['show']);

            Route::resource('menu','MenuController');
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
            Route::resource('page','PageController')->except('show');
            Route::get('page/component','SectionController@componentAdd')->name('user_component_store');
            Route::get('page/component/{page_component}','PageController@componentEditor')->name('user_component');
            Route::post('page/component/{page_component}','PageController@componentSave');
            Route::delete('page/component/{page_component}/delete','SectionController@componentRemove')->name('user_component.delete');
            Route::post('section/{section}/component', ['as' => 'section.component', 'uses' => 'SectionController@sectionComponentUpdate']);
            Route::put('section/{section}/user', ['as' => 'section.user', 'uses' => 'SectionController@userUpdate']);
            Route::post('component/sort','SectionController@sort')->name('component.sort');
            Route::resource('component','ComponentController');
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
                Route::post('upload', ['uses' => 'MediaController@upload', 'as' => 'upload']);
            });

            Route::group([
                'as'     => 'scaffold_interface.',
            ], function () {
                Route::get('{scaffold_interface:slug}/relationship', ['uses' =>'ScaffoldController@relationship', 'as' => 'relationship']);
                Route::get('{scaffold_interface:slug}', ['uses' => 'ScaffoldController@index', 'as' => 'index']);
                Route::get('{scaffold_interface:slug}/create', ['uses' => 'ScaffoldController@create', 'as' => 'create']);
                Route::post('{scaffold_interface:slug}', ['uses' => 'ScaffoldController@store', 'as' => 'store']);
                Route::get('{scaffold_interface:slug}/{id}/edit', ['uses' => 'ScaffoldController@edit', 'as' => 'edit']);
                Route::put('{scaffold_interface:slug}/{id}', ['uses' => 'ScaffoldController@update', 'as' => 'update']);
                Route::delete('{scaffold_interface:slug}/{id}', ['uses' => 'ScaffoldController@destroy', 'as' => 'destroy']);
                Route::get('{scaffold_interface:slug}/{id}', ['uses' => 'ScaffoldController@show', 'as' => 'show']);
                Route::get('delete_relationship/{id}', ['uses' => 'ScaffoldController@deleteRelationship', 'as' => 'delete_relationship']);
                Route::post('{scaffold_interface:slug}/sort', ['uses' => 'ScaffoldController@sort', 'as' => 'sort']);
            });
        });
    });

    Route::prefix(LaravelLocalization::setLocale())->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])->group(function () {
        Route::post('contact', 'HomeController@contact');
        Route::get('/', 'HomeController@index');
        try {
            foreach (\Sina\Shuttle\Models\Page::all() as $page){
                Route::get($page->url.'/{slug?}', 'HomeController@index')->where('slug', '.*');
            }
        }catch (\Exception $exception){}
    });
});


