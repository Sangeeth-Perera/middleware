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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hl7', function () {
    return view('hl7_messageGenerator');
});

//Route::get('/interface', function () {
  //  return view('mainInterface');
//});




Route::get('/request', function () {
    return view('requestData');
});



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/interface', 'SangaController@test');
Route::get('/patient', 'PatientRegisterController@count');
Route::get('/patient/admit', 'PatientAdmitController@count');

Route::get('{key}/generateA01', 'PatientRegisterController@generateA01');
Route::get('{key}/generateAA01', 'PatientRegisterController@generateAA01');

//Patinet Admission
Route::get('{key}/generateA01', 'PatientAdmitController@generateA01');
Route::get('{key}/generateA03', 'PatientDischargeController@generateA03');
//patient discharge
Route::get('/patient/discharge', 'PatientDischargeController@count');

//message history
Route::get('/logs/history', 'MessageHistoryController@count');


