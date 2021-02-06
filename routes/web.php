<?php

use App\Mail\TestAmazonSes;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientVaccineController;

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
Route::resource('patientvaccine', PatientVaccineController::class);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vaccine', 'CoverController@vaccineGet')->name('vaccine_get');
Route::post('/vaccine', 'CoverController@vaccinePost')->name('vaccine_post');
Route::post('/affirm', 'CoverController@vaccinePostAffirm')->name('vaccine_post_affirm');

/*
 *
 *  Testing BurstIq methods
 *
 */

Route::get('/biq/test-private', 'BurstIqTestController@private')->name('test_private');
Route::get('/biq/test-lookups', 'BurstIqTestController@lookups')->name('test_lookups');
Route::get('/biq/test-status', 'BurstIqTestController@status')->name('test_status');
Route::get('/biq/test-login', 'BurstIqTestController@login')->name('test_login');

Route::get('/biq/find', 'BurstIqController@find')->name('biq_find');
Route::get('/biq/get', 'BurstIqController@get')->name('biq_get');

Route::get('/biq/test-getting-a-chain', 'BurstIqTestController@testGettingAChain')->name('test_getting_a_chain');
/*
 *
 *  BurstIq Model Classes
 */
Route::get('/biq/test-upserting-a-patient', 'BurstIqTestController@testUpsertingAPatient')->name('test_upserting_a_patient');

Route::get('/biq/test-upserting-patients', 'BurstIqTestController@testUpsertingPatients')->name('test_upserting_patients');
Route::get('/biq/test-upserting-providers', 'BurstIqTestController@testUpsertingProviders')->name('test_upserting_providers');
Route::get('/biq/test-upserting-sites', 'BurstIqTestController@testUpsertingSites')->name('test_upserting_sites');
Route::get('/biq/test-upserting-schedules', 'BurstIqTestController@testUpsertingSchedules')->name('test_upserting_schedules');

Route::get('/biq/test-getting-a-patient', 'BurstIqTestController@testGettingAPatient')->name('test_getting_a_patient');
Route::get('/biq/test-getting-a-provider', 'BurstIqTestController@testGettingAProvider')->name('test_getting_a_provider');
Route::get('/biq/test-getting-site-profile', 'BurstIqTestController@testGettingSiteProfile')->name('test_getting_site_profile');
Route::get('/biq/test-getting-drug-profile', 'BurstIqTestController@testGettingDrugProfile')->name('test_getting_drug_profile');
Route::get('/biq/test-getting-question-profile', 'BurstIqTestController@testGettingQuestionProfile')->name('test_getting_question_profile');
Route::get('/biq/test-getting-encounter-schedule', 'BurstIqTestController@testGettingEncounterSchedule')->name('test_getting_encounter_schedule');
Route::get('/biq/test-getting-encounter', 'BurstIqTestController@testGettingEncounter')->name('test_getting_encounter');
Route::get('/biq/test-getting-procedure-results', 'BurstIqTestController@testGettingProcedureResults')->name('test_getting_procedure_results');
Route::get('/biq/test-getting-patient-schedule-site-query', 'BurstIqTestController@testGettingPatientScheduleSiteQuery')->name('test_getting_patient_schedule_site_query');


Route::get('/email/test', function () {
    Mail::to('erikolson1965@gmail.com')->send(new TestAmazonSes('It works!'));
});

Route::get('/vsee/test', 'VSeeController@test')->name('vsee_test');


/*
 *
 *  Actual BurstIq methods
 *
 */

Route::get('/biq/status', 'BurstIqController@status')->name('biq-status');
Route::get('/biq/login', 'BurstIqController@login')->name('biq-login');


#Route::webhooks('api/xcelerateudi');

Route::get('/addvaccine', function () {
    return view('addvaccine');
});

Route::get('/patientquestionaire', function () {
    return view('patientquestionaire');
});

Route::get('/providerquestionaire', function () {
    return view('providerquestionaire');
});

Route::post('/vsee/redirect', 'VSeeController@redirect')->name('vsee_redirect');
Route::get('/vsee/return', 'VSeeController@return')->name('vsee_return');
Route::post('/vsee/webhook', 'VSeeController@webhook')->name('vsee_webhook');
Route::get('/vsee/webhook', 'VSeeController@webhook')->name('vsee_webhook');
Route::get('/vsee/loginas', 'VSeeController@loginAs')->name('vsee_loginas');
