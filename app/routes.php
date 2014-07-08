<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any('/', 'DoctorsController@searchDoctors');
Route::any('/register', array('as' => 'registerUser', 'uses' => 'UserManagementController@registerUser'));
Route::any('/resetpassword', array('as' => 'resetPassword', 'uses' => 'UserManagementController@resetPassword'));
Route::get('/resetpasswordemailsent',  array('as' => 'resetPasswordEmailSent', 'uses' => 'UserManagementController@resetPasswordEmailSent'));
Route::any('/resetpasswordconfirm/{resetCode}', array('as' => 'resetPasswordConfirm', 'uses' => 'UserManagementController@resetPasswordConfirm'));
Route::get('/resetpasswordthanks', array('as' => 'resetPasswordThanks', 'uses' => 'UserManagementController@resetPasswordThanks'));
Route::any('/login', array('as' => 'login', 'uses' => 'UserManagementController@login'));
Route::any('/logout', array('as' => 'logout', 'uses' => 'UserManagementController@logout'));
Route::any('/myprofile', array('as' => 'manageUserProfile', 'uses' => 'UserManagementController@manageUserProfile'));
Route::any('/doctors', array('as' => 'searchDoctors', 'uses' => 'DoctorsController@searchDoctors'));
Route::get('/doctor/{id}', array('as' => 'showDoctor', 'uses' => 'DoctorsController@show'));
Route::get('/logout', array('as'=> 'logout', 'uses' => "UserManagementController@logout"));
Route::post('/doctorratings', array('as' => 'doctorRating.store', 'uses' => 'DoctorRatingsController@store'));
Route::post('/doctor/{id}/education_record',                               array('before' => 'currentUser', 'as' => 'educationRecord.store',      'uses' => 'EducationRecordsController@store'));
Route::get('/doctor/{id}/education_record/create',                         array('before' => 'currentUser', 'as' => 'educationRecord.create',     'uses' => 'EducationRecordsController@create'));
Route::put('/doctor/{id}/education_record/{education_record_id}',          array('before' => 'currentUser', 'as' => 'educationRecord.update',     'uses' => 'EducationRecordsController@update'));
Route::get('/doctor/{id}/education_record/{education_record_id}/edit',     array('before' => 'currentUser', 'as' => 'educationRecord.edit',       'uses' => 'EducationRecordsController@edit'));
Route::delete('/doctor/{id}/education_record/{education_record_id}',       array('before' => 'currentUser', 'as' => 'educationRecord.destroy',    'uses' => 'EducationRecordsController@destroy'));

Route::get('/doctorprofile', array('as' => 'doctorcreate', 'uses' => 'DoctorsController@create'));
Route::post('/doctorstore', array('as' => 'doctorstore', 'uses' => 'DoctorsController@store'));
Route::get('/doctorprofileedit', array('as' => 'doctorprofileedit', 'uses' => 'DoctorsController@edit'));
Route::post('/doctorprofileupdate', array('as' => 'doctorprofileupdate', 'uses' => 'DoctorsController@update'));