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

Route::view('/','login');
Route::view('user-home','user-home');
Route::view('admin-home', 'admin-home');

Route::post('auth', 'UserController@auth')->name('auth');

Route::post('handover', 'ConsignmentController@handover');
Route::post('searchByDates', 'ConsignmentController@searchByDates')->name('searchByDates');;

//changes containers display: either top 5 or show all
Route::get('containers_switch_show_mode/{mode?}', 'ContainerController@index');

//changes containers display: either top 5 or show all
Route::get('consignments_create/{containerId}', 'ConsignmentController@create');

Route::post('ajaxAddForwarder', 'AjaxController@addForwarder')->name('ajax_addForwarder');
Route::post('ajaxAddConsigner', 'AjaxController@addConsigner')->name('ajax_addConsigner');
Route::post('ajaxAddConsignee', 'AjaxController@addConsignee')->name('ajax_addConsignee');

Route::group(['middleware'=>'admin'], function(){
	Route::resource('users', 'UserController');
	Route::resource('consigners', 'ConsignerController');
	Route::resource('consignees', 'ConsigneeController');
	Route::resource('forwarders', 'ForwarderController');
	Route::resource('unloaders', 'UnloaderController');
	Route::resource('logs', 'LogController');
});

//Route::group(['middleware'=>'user'], function(){
	Route::resource('containers', 'ContainerController');
	Route::resource('consignments', 'ConsignmentController');
	Route::resource('payments', 'PaymentController');
	Route::resource('recoveries', 'RecoveryController');
//});

Route::get('signout','UserController@signout')->name('signout');
Route::get('changePassword','UserController@changePassword')->name('changePassword');
Route::get('dashboard','UserController@dashboard')->name('dashboard');
Route::post('updatePassword','UserController@updatePassword')->name('updatePassword');





