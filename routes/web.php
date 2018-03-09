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



Route::get('/', 'JobList\JobPositionController@getPage')->name('home');

Route::get('/api/positions', 'JobList\JobPositionController@getPositions')
    ->name('api.jobList.positions');

Route::get('/positions/{position}', 'JobList\JobPositionController@getPosition')
    ->name('jobList.position');

Route::post('/positions/{position}', 'JobList\CandidateController@apply');

Route::get('/login', 'Auth\LoginController@getLoginPage')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/register', 'Auth\RegisterController@getRegisterPage')->name('register');
Route::post('/register', 'Auth\RegisterController@register')->name('register');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/manage/company', 'Manage\CompanyController@showCompany')->name('manage.company');
    Route::put('/manage/company', 'Manage\CompanyController@updateCompanyData');
    Route::get('/manage/company/drive/setup','Manage\CompanyController@setupDriveAccess')
        ->name('manage.company.drive.setup') ;



    Route::get('/manage/job-position/new', 'Manage\JobPositionController@showFormForNewPosition')
        ->name('manage.job-position.new');
    Route::post('/manage/job-position/new', 'Manage\JobPositionController@createNewJobPosition');

    Route::get('/manage/job-position', 'Manage\JobPositionController@showJobPositions')
        ->name('manage.job-positions');

    Route::get('/api/manage/job-position', 'Manage\JobPositionController@getJobPositions')
        ->name('api.manage.job-positions');

    Route::get('/manage/job-position/{id}', 'Manage\JobPositionController@showJobPosition')
        ->name('manage.job-position');

    Route::put('/manage/job-position/{id}', 'Manage\JobPositionController@updateJobPosition');

    Route::post('/manage/job-position/{position}/candidate/{candidate}/accept',
        'Manage\CandidateController@acceptCandidate')->name('manage.job-position.accept');

});

