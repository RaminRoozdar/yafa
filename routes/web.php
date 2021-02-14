<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Frontend'],function (){
    Route::get('/', 'HomeController@index')->name('home');
});

Auth::routes();

Route::group(['namespace' => 'Frontend'], function () {
    //contact
    Route::post('/contactUs/insert', 'ContactController@contactInsert')->name('contactInsert');
});
Route::get('/login-phone', [\App\Http\Controllers\AuthController::class, 'loginPhone'])->name('loginPhone');
//Route::get('/login-email', [\App\Http\Controllers\AuthController::class, 'loginEmail'])->name('loginEmail');
//Route::get('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
//Route::post('/register', [\App\Http\Controllers\AuthController::class, 'doRegister'])->name('doRegister');
Route::post('/login-phone', [\App\Http\Controllers\AuthController::class, 'doLoginPhone'])->name('doLoginPhone');
//Route::post('/login-email', [\App\Http\Controllers\AuthController::class, 'doLoginEmail'])->name('doLoginEmail');
Route::get('/verify', [\App\Http\Controllers\AuthController::class, 'verify'])->name('verify');
Route::post('/doVerify', [\App\Http\Controllers\AuthController::class, 'doVerify'])->name('doVerify');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware' => 'auth', 'as' => 'admin.'], function () {
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', 'UsersController@index')->name('index');
        Route::get('data', 'UsersController@data')->name('data');
        Route::get('add', 'UsersController@create')->name('create');
        Route::post('add', 'UsersController@store')->name('store');
        Route::get('edit/{id}', 'UsersController@edit')->name('edit');
        Route::post('update/{id}', 'UsersController@update')->name('update');
    });
    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::get('/', 'RolesController@index')->name('index');
        Route::get('add', 'RolesController@create')->name('create');
        Route::post('add', 'RolesController@store')->name('store');
        Route::get('show/{id}', 'RolesController@show')->name('show');
        Route::get('edit/{id}', 'RolesController@edit')->name('edit');
        Route::post('update/{id}', 'RolesController@update')->name('update');
    });
    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get('/', 'CategoryController@index')->name('index');
        Route::get('add', 'CategoryController@create')->name('create');
        Route::post('add', 'CategoryController@store')->name('store');
        Route::get('edit/{id}', 'CategoryController@edit')->name('edit');
        Route::post('update/{id}', 'CategoryController@update')->name('update');
    });
    Route::group(['prefix' => 'articles', 'as' => 'articles.'], function () {
        Route::get('/', 'ArticleController@index')->name('index');
        Route::get('data', 'ArticleController@data')->name('data');
        Route::get('add', 'ArticleController@create')->name('create');
        Route::post('add', 'ArticleController@store')->name('store');
        Route::get('edit/{id}', 'ArticleController@edit')->name('edit');
        Route::post('update/{id}', 'ArticleController@update')->name('update');
    });
    Route::group(['prefix' => 'sliders', 'as' => 'sliders.'], function () {
        Route::get('/', 'SliderController@index')->name('index');
        Route::get('add', 'SliderController@create')->name('create');
        Route::post('add', 'SliderController@store')->name('store');
        Route::get('edit/{id}', 'SliderController@edit')->name('edit');
        Route::post('update/{id}', 'SliderController@update')->name('update');
    });
    Route::group(['prefix' => 'images', 'as' => 'images.'], function () {
        Route::post('/image-upload', 'ImageController@upload')->name('upload');
    });
    Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function () {
        Route::get('/', 'ContactController@index')->name('index');
        Route::get('data', 'ContactController@data')->name('data');
    });
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('/', 'SettingController@edit')->name('index');
        Route::put('update', 'SettingController@update')->name('update');

    });


});