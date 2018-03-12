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

Route::get('/', 'IndexController@index');
Route::get('url',function(){
    return 'data';
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::get('/user','DashboardController@user')->name('user');
Route::get('/admin','DashboardController@admin')->name('admin');

/**
 * Ticket Controller
 */
Route::get('tickets','TicketsController@index');

/**
 * Payments Controller
 */
Route::get('/transactions','PaymentsController@index');
Route::post('/payment','PaymentsController@make');
Route::get('/payment/verify/{id}','PaymentsController@verify');
Route::get('/payment/decline/{id}','PaymentsController@decline');

/**
 * Files Controller
 */
Route::post('/file','FilesController@store');
Route::get('/file/download/{id}','FilesController@download');
Route::get('/files','FilesController@index');
Route::get('/file/list','FilesController@list');
Route::get('/file/{id}','FilesController@about');
Route::get('/file/purchase/{id}','FilePurchasesController@purchase');
Route::get('series','FilesController@series');
Route::get('videos','FilesController@videos');
Route::get('documents','FilesController@documents');
Route::get('file/delete/{id}','FilesController@delete');

/**
 * Message Controller
 */

Route::post('/message','MessagesController@store');
Route::get('/message/read/{id}','MessagesController@read');
Route::get('/message','MessagesController@index');
Route::post('message/reply/{id}','MessagesController@reply');
Route::post('message/send/{id}','MessagesController@send');

/**
 * Notification Controller
 */

Route::post('/notification','NotificationsController@store');
Route::get('/notifications','NotificationsController@index');
Route::get('/notifications/dismiss/{id}','NotificationsController@dismiss');

/**
 * Users Controller
 */
Route::post('user','ProfileController@create');
Route::get('users','ProfileController@users');
Route::post('/profile','ProfileController@store');
Route::get('/profile','ProfileController@read');
Route::get('/profiles','ProfileController@index');
Route::get('/user/reset/{id}','ProfileController@reset');
Route::get('user/delete/{id}','ProfileController@delete');

/**
 * Settings
 */

Route::get('settings','ProfileController@settings');
Route::post('settings','ProfileController@savesettings');

/**
 * shop
 */
Route::get('shop','DashboardController@shop');
Route::get('shop/{id}','IndexController@shop');

/**
 * withdraws
 */
Route::post('withdraw','WithdrawsController@request');
Route::post('withdraw/approve/{id}','WithdrawsController@approve');
Route::get('withdraw/deny/{id}','WithdrawsController@deny');
Route::get('withdrawals','WithdrawsController@index');
