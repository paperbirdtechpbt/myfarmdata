<?php

use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/dashboardevent', 'HomeController@dashboardevent')->name('dashboardevent');
Route::get('/dashboardfield', 'HomeController@dashboardfield')->name('dashboardfield');
Route::post('/getchartdetail', 'HomeController@getchartdetail')->name('getchartdetail');


Route::resources(['/user'=>'UserController']);
Route::post('/getCommunityGroupByUser', 'UserController@getCommunityGroupByUser')->name('getCommunityGroupByUser');
Route::resources(['/collectactivity'=>'CollectActivityController']);
Route::resources(['/sensor'=>'SensorController']);
Route::resources(['/role'=>'RoleController']);
Route::resources(['/communitygrp'=>'CommunityGrpController']);
Route::resources(['/unit'=>'UnitController']);
Route::resources(['/sensortype'=>'SensorTypeController']);
Route::resources(['/pack'=>'PackController']);
Route::resources(['/collectdata'=>'CollectDataController']);
Route::resources(['/list'=>'ListController']);
Route::resources(['/person'=>'PersonController']);
Route::resources(['/field'=>'FieldController']);
Route::post('/getFields', 'FieldController@getFields')->name('getFields');
Route::resources(['/team'=>'TeamController']);
Route::resources(['/alertrange'=>'AlertRangeController']);
Route::post('/getResultByCollectActivity', 'AlertRangeController@getResultByCollectActivity')->name('getResultByCollectActivity');
Route::resources(['/zone'=>'ZoneController']);
Route::resources(['/container'=>'ContainerController']);
Route::resources(['/containerarch'=>'ContainerObjectArchController']);
// Route::get('/field/test_map', 'FieldController@index');
// Route::get('/field/test_map1', function(){
//     echo "hello";
// });
Route::get('/test_map', 'FieldController@test_map');
Route::view('/draw_rect', 'allpages.field.draw_rect');
Route::view('/rect_bound', 'allpages.field.rect_bound');
Route::view('/rect_field', 'allpages.field.rect_field');

Route::get('/report', 'ReportController@viewReport');
Route::post('/getpackresult', 'CollectDataController@getpackresult')->name('getpackresult');
Route::post('/getvaluetype', 'CollectDataController@getvaluetype')->name('getvaluetype');
Route::post('/getPackReportData', 'ReportController@getPackReportData')->name('getPackReportData');
Route::get('/resetpassword', 'AdminController@password')->name('password');
Route::post('/updatepassword', 'AdminController@updatepassword')->name('updatepassword');
Route::post('/rolefromemailid', 'AdminController@rolefromemailid')->name('rolefromemailid');
Route::get('changeStatus','PackController@changeStatus')->name('changeStatus');
Route::post('createPack','PackController@createPack')->name('createPack');

Route::get('/about_us', function () { return view('about_us'); })->name('about_us');
Route::get('/privacy_policy', function () { return view('privacy_policy'); })->name('privacy_policy');
Route::get('/contact_us', function () { return view('contact_us'); })->name('contact_us');

Route::get('/forgot_password', 'Auth\ForgotPasswordController@forgot_password');
Route::post('/forgot_password', 'Auth\ForgotPasswordController@password');
Route::get('/reset_password/{email}/{code}', 'Auth\ForgotPasswordController@reset');
Route::post('/reset_password/{email}/{code}', 'Auth\ForgotPasswordController@reset_password');

Route::get('/resetpassword/', 'Auth\ForgotPasswordController@resetpassword');
Route::post('/resetpassword_update/{email}', 'Auth\ForgotPasswordController@resetpassword_update');

Route::resources(['/dashboardsetting'=>'DashboardSettingController']);
Route::resources(['/graphchart'=>'GraphsChartsController']);
Route::post('/getDashboardObjectKey', 'DashboardSettingController@getdashboardobjectkey')->name('getdashboardobjectkey');

Route::resources(['/taskconfig'=>'TaskConfigController']);
Route::post('/gettaskconfig', 'TaskConfigController@gettaskconfig')->name('gettaskconfig');

Route::resources(['/task'=>'TaskController']);
Route::post('/taskExecuteFunction', 'TaskController@taskExecuteFunction')->name('taskExecuteFunction');
Route::post('/taskContainer', 'TaskController@taskContainer')->name('taskContainer');

Route::post('/taskPacks', 'TaskController@taskPacks')->name('taskPacks');
Route::post('/taskPersons', 'TaskController@taskPersons')->name('taskPersons');
Route::post('/taskStartEndDate', 'TaskController@taskStartEndDate')->name('taskStartEndDate');
Route::post('/getMediaFiles', 'TaskController@getMediaFiles')->name('getMediaFiles');
Route::post('/getPack', 'TaskController@getPack')->name('getPack');
Route::post('/gettaskobjects', 'TaskController@gettaskobjects')->name('gettaskobjects');
Route::delete('/taskobject/{id}', 'TaskController@destroytaskobject')->name('destroytaskobject');

Route::resources(['/event'=>'EventController']);
Route::post('/getEvents', 'EventController@getEvents')->name('getEvents');

Route::post('/checkunique', 'UniqueController@checkunique')->name('checkunique');

Route::resources(['/notification'=>'NotificationController']);
Route::get('notificationChangeStatus','NotificationController@changeStatus')->name('notificationChangeStatus');
Route::resources(['/incident'=>'IncidentController']);
Route::get('incidentChangeStatus','IncidentController@changeStatus')->name('incidentChangeStatus');


Auth::routes();

