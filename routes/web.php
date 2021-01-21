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

/*
 *
 *  Testing BurstIq methods
 *
 */

Route::get('/biq/test-status', 'BurstIqTestController@status')->name('test_status');
Route::get('/biq/test-login', 'BurstIqTestController@login')->name('test_login');
Route::get('/biq/test-getting-a-chain', 'BurstIqTestController@testGettingAChain')->name('test_getting_a_chain');
Route::get('/biq/test-getting-a-patient', 'BurstIqTestController@testGettingAPatient')->name('test_getting_a_patient');
Route::get('/biq/test-upserting-a-patient', 'BurstIqTestController@testUpsertingAPatient')->name('test_upserting_a_patient');


/*
 *
 *  Actual BurstIq methods
 *
 */

Route::get('/biq/status', 'BurstIqController@status')->name('status');
Route::get('/biq/login', 'BurstIqController@login')->name('login');


#Route::webhooks('api/xcelerateudi');

Route::get('/addvaccine', function () {
    return view('addvaccine');
});


