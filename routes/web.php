<?php

use Illuminate\Support\Facades\Route;
use App\Http\Requests;
use App\Http\Controllers\Auth\RegisterController;


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

// Route::get('/', function () {
//     return route('login');//auth.login
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::post('/user/create','UserController@store')->name('newUser');
Route::get('/profile', 'ProfileController@profile')->name('profile');
Route::post('/profile/update', 'ProfileController@profileUpdate')->name('profile.update');
Route::post('/profile/{id}/update', 'ImageController@UserProfileImageUpdate')->name('profileImage.update');
Route::get('/profile/passwordchange', 'ProfileController@passwordChange')->name('passwordchange');

// users routes
Route::get('/users','UserController@index')->name('users');
Route::get('/users/register','UserController@create')->name('users.create');
// clients Routes
Route::get('/clients','ClientController@index')->name('clients');
Route::get('/client/{id}/view','ClientController@show')->name('client.view');
Route::get('/clients/{id}/edit','ClientController@edit')->name('client.edit');
Route::get('/clients/create','ClientController@create')->name('client.create');
Route::post('/clients/store','ClientController@store')->name('client.store');
Route::post('/clients/{id}/update','ClientController@update')->name('client.update');
Route::get('/clients/{id}/profile','ClientController@profile')->name('client.profile');
Route::get('/clients/{id}/schedules','ClientController@schedules')->name('client.schedules');


// background routes
Route::get('client/{id}/background/create','BackgroundController@create')->name('client.background');
Route::post('client/background/store','BackgroundController@store')->name('background.store');
Route::post('client/{id}/otherinfo/store','BackgroundController@otherInfoStore')->name('backgroundInfo');

//schedule routes
Route::get('/schedule','ScheduleController@index')->name('schedule');
Route::get('/schedule/view','ScheduleController@view')->name('schedule.view');
Route::get('/schedule/{id}/edit','ScheduleController@edit')->name('schedule.edit');
Route::get('/schedule/create','ScheduleController@create')->name('schedule.create');
Route::post('/schedule/store','ScheduleController@store')->name('schedule.store');


//Records routes
Route::get('/record','RecordController@index')->name('record');
Route::get('/record/view','RecordController@view')->name('record.view');
Route::post('/record/store','RecordController@store')->name('record.store');
Route::post('/record/{id}/update','RecordController@update')->name('record.update');
Route::get('/record/{id1}/create','RecordController@create')->name('record.create');

// issues Routes
Route::get('/issue','IssueController@index')->name('issue');
Route::get('/issue/view','IssueController@view')->name('issue.view');
Route::post('/issue/store','IssueController@store')->name('issue.store');
Route::get('/issue/{id}/edit','IssueController@edit')->name('issue.edit');
Route::get('/client/{id}/issue/create','IssueController@create')->name('issue.create');

// category Routes
Route::get('/category','CategoryController@index')->name('category');
Route::get('/category/view','CategoryController@view')->name('category.view');
Route::post('/category/store','CategoryController@store')->name('category.store');
Route::get('/category/{id}/edit','CategoryController@edit')->name('category.edit');
Route::post('/category/{id}/update','CategoryController@update')->name('category.update');
Route::post('/category/{id}/delete','CategoryController@destroy')->name('category.delete');
Route::get('/category/create','CategoryController@create')->name('category.create');

// category details
Route::get('/categories/{id}/documents','CategoryController@documents')->name('category.documents');
Route::post('/categories/{id}/documents/store','DocumentController@store')->name('categoryDocument.upload');
Route::get('/category/document/{id}/download','DocumentController@download')->name('download.document');
Route::get('/categories/{id}/schedules','ScheduleController@category')->name('category.schedules');
Route::get('/categories/{id}/clients','ClientController@category')->name('category.clients');

// records routes
Route::get('/records','RecordController@index')->name('records');
Route::post('/subissue/store','IssueController@subIssueStore')->name('subissueStore');

// ajax call routes
Route::get('/search','AjaxController@search')->name('search');
Route::get('/search/client','AjaxController@searchClient')->name('searchClient');
Route::get('/schedules/get','AjaxController@schedules')->name('schedules');
Route::get('/password/check','AjaxController@passwordCheck')->name('passwordcheck');
Route::get('/reports','HomeController@reports')->name('reports');

//images controller routes
Route::prefix('profile_image_url')->group(function () {
    Route::get('Client_profiles/{filename}','ImageController@ShowClientImage')
    ->name('ClientImage');
 });

/**
 * report data routes
 */
Route::get('/issues/get','IssueController@fetchIssues')->name('issues.find');
Route::get('/reportGeneral','ReportController@generalReport')->name('reportGeneral');
Route::get('/convertToWord','ReportController@convertToWord')->name('convertToWord');