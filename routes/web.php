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
    return redirect()->route('home');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

//APPOINTMENT ROUTES
Route::get('/appointments', 'AppointmentController@index')->name('appointments.index');
Route::get('/appointments/all', 'AppointmentController@getAppointments')->name('appointments.get');
Route::post('/appointments/store', 'AppointmentController@store')->name('appointments.create');
Route::get('/appointment/edit/{id}', 'AppointmentController@edit');
Route::post('/appointment/update', 'AppointmentController@update');
Route::get('/appointment/delete/{id}', 'AppointmentController@delete');

//CLIENT ROUTES
Route::get('/clients', 'ClientsController@index');
Route::post('/clients/add', 'ClientsController@store');
Route::get('/client/edit/{id}', 'ClientsController@edit');
Route::post('/client/update', 'ClientsController@update');
Route::get('/client/delete/{id}', 'ClientsController@delete');
Route::get('/client/download-meeting-notes', 'ClientsController@downloadMeetingNotes');

//EXPENSES ROUTES
Route::get('/expenses', 'ExpenseController@index');
Route::post('/expenses/add', 'ExpenseController@store');
Route::get('/expense/edit/{id}', 'ExpenseController@edit');
Route::post('/expense/update', 'ExpenseController@update');
Route::get('/expense/delete/{id}', 'ExpenseController@delete');

//FINANCIAL REPORT
Route::get('/financial-report', 'FinancialReportController@index')->name('financial_report.index');
Route::get('/financial-report/export', 'FinancialReportController@export')->name('financial_report.export');
