<?php

use Illuminate\Support\Facades\Route;
//use DB;
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
Route::get('/test', function () {
   try {
    DB::connection()->getPdo();
} catch (\Exception $e) {
    die("Could not connect to the database.  Please check your configuration. error:" . $e );
}
});

Route::get('/welcome', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     return view('loginpage');
// });

// Route::get('/mainlayout', function () {
//     return view('mainlayout');
// });

// Route::get('/dashboard', function () { return view('dashboard'); });
// Route::get('/user', function () { return view('allpages/user'); });


Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

// Route::resources(['/user'=>'UserController']);
// Route::resources(['/collectactivity'=>'CollectActivityController']);
// Route::resources(['/sensor'=>'SensorController']);
// Route::resources(['/role'=>'RoleController']);
// Route::resources(['/communitygrp'=>'CommunityGrpController']);
// Route::resources(['/unit'=>'UnitController']);
// Route::resources(['/sensortype'=>'SensorTypeController']);
Route::resources(['/pack'=>'PackController']);
Route::resources(['/collectdata'=>'CollectDataController']);

// Route::get('/report', function () {
//     return view('allpages.report.report');
// });
Route::get('/report', 'ReportController@viewReport');
Route::post('/getpackresult', 'CollectDataController@getpackresult')->name('getpackresult');
Route::post('/getvaluetype', 'CollectDataController@getvaluetype')->name('getvaluetype');
Route::post('/getPackReportData', 'ReportController@getPackReportData')->name('getPackReportData');
Route::get('/resetpassword', 'AdminController@password')->name('password');
Route::post('/updatepassword', 'AdminController@updatepassword')->name('updatepassword');
Route::post('/rolefromemailid', 'AdminController@rolefromemailid')->name('rolefromemailid');
Route::get('changeStatus','PackController@changeStatus')->name('changeStatus');

Route::get('/forgot_password', 'Auth\ForgotPasswordController@forgot_password');
Route::post('/forgot_password', 'Auth\ForgotPasswordController@password');
Route::get('/reset_password/{email}/{code}', 'Auth\ForgotPasswordController@reset');
Route::post('/reset_password/{email}/{code}', 'Auth\ForgotPasswordController@reset_password');
// Route::middleware('adminrole')->group(function () {
//     Route::get('/roleofadmin', function () {
//         return "hello admin";
//     });
    Route::resources(['/user'=>'UserController']);
    Route::resources(['/collectactivity'=>'CollectActivityController']);
    Route::resources(['/sensor'=>'SensorController']);
    Route::resources(['/role'=>'RoleController']);
    Route::resources(['/communitygrp'=>'CommunityGrpController']);
    Route::resources(['/unit'=>'UnitController']);
    Route::resources(['/sensortype'=>'SensorTypeController']);

//     Route::get('roleofadmin123', function () {
//         return "hello admin123";
//     });
// });

// Route::middleware('farmerrole')->group(function () {
//     Route::get('/roleoffarmer', function () {
//         return "hello admin";
//     });
//     Route::resources(['/pack'=>'PackController']);
//     Route::resources(['/collectdata'=>'CollectDataController']);

//     Route::get('roleofadmin123', function () {
//         return "hello admin123";
//     });
// });

Route::get('/about_us', function () { return view('about_us'); })->name('about_us');
Route::get('/privacy_policy', function () { return view('privacy_policy'); })->name('privacy_policy');
Route::get('/contact_us', function () { return view('contact_us'); })->name('contact_us');



Auth::routes();

// Route::get('/', 'HomeController@index')->name('home');
// Route::resources(['/user'=>'UserController']);

