<?php

use App\Http\Controllers\LabResultsPatientCOVIDTestController;
use App\Mail\TestAmazonSes;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientVaccineController;
use Picqer\Barcode\BarcodeGeneratorSVG;

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

/* --------------- LabResults ---------------*/

if (isset($_SERVER['SERVER_NAME']) &&
    ($_SERVER['SERVER_NAME'] == "trackmylabresults.com" || $_SERVER['SERVER_NAME'] == "trackmylabresults.us")) {


    Route::get('/', 'Auth\LabResultsLoginController@login');
    Route::get('labResults/ForgotPassword', 'Auth\LabResultsForgotPasswordController@ForgotPassword');

    Route::get('labResults/new-patient', 'LabResultsHomeController@newPatient');
    Route::post('labResults/new-patient', 'LabResultsHomeController@registerNewPatient')->name('register_new_parent');
    Route::get('/home', 'LabResultsHomeController@index')->name('home');

    Route::get('labResults/terms', function () {
        return view("terms.terms");
    });

    Route::get('labResults/policy', function () {
        return view("terms.policy");
    });

    Route::get('labResults/covid/{id}/{name}', 'LabResultsHomeController@showCovid')->name('showCovid');
    Route::post('/labResults/saveCovid19', 'LabResultsHomeController@saveCovid19')->name('showCovid');

    Route::get("/labResults/CovidTest", 'LabResultsPatientCOVIDTestController@patient_COVID_test_modal')->name('showCovidTest');
    //Route::get('/patient-test/{$id}','LabResultsPatientCOVIDTestController@show')->name('patient_test_get');
    Route::post('/patient-test', 'LabResultsPatientCOVIDTestController@insert')->name('patient_test_post');
    Route::get('/patient-test/{$code}.png', 'LabResultsPatientCOVIDTestController@barcode');
    Route::post('/patient-test-kit', 'LabResultsPatientCOVIDTestController@testKit')->name('patient-test-kit');

} else {
    /* --------------- Track My Solutions ---------------*/
    Route::get('/', function () {
        return redirect(route('login'));//return view('welcome');
    });

    Route::get('/new-patient', 'HomeController@newPatient');
    Route::post('/new-patient', 'HomeController@registerNewPatient')->name('register_new_parent');
    Route::get('/home', 'HomeController@index')->name('home');

}


if (env('APPLICATION', 'labresult')) {
    Route::get('/', 'Auth\LabResultsLoginController@login');
    Route::get('labResults/ForgotPassword', 'Auth\LabResultsForgotPasswordController@ForgotPassword');

    Route::get('labResults/new-patient', 'LabResultsHomeController@newPatient');
    Route::post('labResults/new-patient', 'LabResultsHomeController@registerNewPatient')->name('register_new_parent');
    Route::get('/home', 'LabResultsHomeController@index')->name('home');

    Route::get('labResults/terms', function () {
        return view("terms.terms");
    });

    Route::get('labResults/policy', function () {
        return view("terms.policy");
    });

    Route::get('labResults/covid/{id}/{name}', 'LabResultsHomeController@showCovid')->name('showCovid');
    Route::post('/labResults/saveCovid19', 'LabResultsHomeController@saveCovid19')->name('showCovid');

    Route::get("/labResults/CovidTest", 'LabResultsPatientCOVIDTestController@patient_COVID_test_modal')->name('showCovidTest');
}

//Route::get('/vaccine', function () {
//    return redirect(route('login'));
//});

Auth::routes();
Route::resource('patientvaccine', PatientVaccineController::class);


Route::get('/vaccine', 'CoverController@vaccineGet')->name('vaccine_get');
Route::post('/vaccine', 'CoverController@vaccinePost')->name('vaccine_post');
Route::post('/affirm', 'CoverController@vaccinePostAffirm')->name('vaccine_post_affirm');

Route::get('/barcode/{code}.svg', function ($code) {
    $bc = new BarcodeGeneratorSVG();
    $contents = $bc->getBarcode($code, $bc::TYPE_CODE_128);
    return response($contents)->header('Content-Type', 'image/svg+xml');
})->name('barcode');

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
Route::get('/biq/get', 'BurstIqController@get')->name('biq_get');
Route::get('/biq/bulkadd', 'BurstIqTestController@bulkAdd')->name('biq_bulkadd');
Route::post('/biq/bulkadd', 'BurstIqTestController@bulkAdd')->name('biq_bulkadd');
Route::get('/biq/bulkaddbarcode', 'BurstIqTestController@bulkAddBarcode')->name('biq_bulkaddbarcode');
Route::post('/biq/bulkaddbarcode', 'BurstIqTestController@bulkAddBarcode')->name('biq_bulkaddbarcode');
Route::get('/biq/encounters', 'BurstIqController@encounters')->name('biq_encounters');
Route::get('/biq/myVaccines', 'BurstIqController@myVaccines');


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
Route::get('/biq/test-upserting-encounters', 'BurstIqTestController@testUpsertingEncounters')->name('test_upserting_encounters');

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

Route::post('/tools/importzilla', 'BurstIqTestController@bulkAddPatients')->name('importzilla');

if (env('APP_ENV') == 'development') {
    Route::get('/vsee/test_complete', 'VSeeController@test_completing_a_visits');
    Route::get('/vsee/test_queue', function () {
        dispatch(new \App\Jobs\CompleteVisit(-1, -1, time()));
        return 'In the queue';
    });

    Route::get('/hello-queue/{yourName}', function ($yourName) { // Example of sending a job to the queue
        dispatch(new \App\Jobs\HelloWorld($yourName));
        return 'Hello "yourName" is queued';
    });

    Route::get('/hello-now/{yourName}', function ($yourName) {  //Example od running the job now and waiting for the response
        dispatch(new \App\Jobs\HelloWorld($yourName))->onConnection('sync');
    });
}


/*
 *
 *  Actual BurstIq methods
 *
 */

Route::get('/biq/barcode', 'BurstIqController@barcode')->name('biq-barcode');
Route::post('/biq/barcode', 'BurstIqController@barcode')->name('biq-barcode');
// defunct Route::get('/biq/login', 'BurstIqController@login')->name('biq-login');


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
Route::get('/vsee/visits', 'VSeeController@Visits')->name('vsee_visits');

Route::post('/vsee/saveonly', 'VSeeController@saveonly')->name('vsee_saveonly');

Route::get('profile/{user}', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
Route::patch('profile/{user}', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);

Route::get('/test/result/', "TestResultController@result")->name('user-results');
Route::get('search-sites', 'LocationController@searchSites');
Route::get('switch-site', 'LocationController@switchSite');
Route::get('change-locale/{locale}', 'LanguageController@changeLocale')->name('change_locale');
Route::get('create-patient', 'UserController@createPatient')->name('create.patient');
Route::get('activate-user/{binary}', 'UserController@activateUser')->name('password.create');
Route::post('activate-user/{binary}', 'UserController@createPassword')->name('password.create');
Route::get('scan-barcode', 'BarcodeController@scan')->name('barcode.scan');
Route::post('scan-barcode', 'BarcodeController@getUserInformation')->name('barcode.scan');
Route::post('barcode-image', 'BarcodeController@generateBarcodeImage')->name('barcode.image');

Route::group(["prefix" => "admin", "as" => "admin.", "namespace" => "Admin", "middleware" => "not.admin"], function () {
    Route::get("/", 'AdminController@index')->name("dashboard");
    Route::get("/login", "LoginController@index")->name("login");
    Route::get('bulk-import', 'AdminController@bulkImport')->name("bulk-import");
    Route::post('create-users-from-excel', 'AdminController@createUsersFromExcel')->name('create-users-from-excel');
});
