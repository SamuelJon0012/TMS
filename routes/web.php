<?php

use Illuminate\Support\Facades\Route;

// use jeremykenedy\LaravelRoles\Route;

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
    return redirect(route('login'));//return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Grab the jwt from BurstIq for the current user and store it as a Cookie
#Route::get('/jwt', 'BurstIqController@jwt')->name('jwt');

Route::get('/biq/status', 'BurstIqController@status')->name('status');
Route::get('/biq/login', 'BurstIqController@login')->name('login');
Route::get('/biq/test', 'BurstIqController@test')->name('test');
Route::get('/biq/test2', 'BurstIqController@test2')->name('test2');

#Route::webhooks('api/xcelerateudi');

Route::get('/addvaccine', function () {
    return view('addvaccine');
});


