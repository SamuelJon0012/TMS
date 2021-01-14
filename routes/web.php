<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/roles', 'LaravelRolesController@index')->name('laravelroles::roles.index'); //jeremykenedy\laravel-roles\src\App\Http\Controllers

Route::group(['prefix' => 'roles', 'namespace' => 'jeremykenedy\LaravelRoles\App\Http\Controllers', 'middleware' => ['web', 'auth']], function () {

    // Dashboards
    Route::get('/', 'LaravelRolesController@index')->name('laravelroles::roles.index');
    // Route::get('/cleared', ['uses' => 'LaravelLoggerController@showClearedActivityLog'])->name('cleared');

});
