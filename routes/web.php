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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//for post 
Route::get('/post', 'PostController@home');
Route::resource('/post/posts','PostController');
//Route::get('/post/add-new','PostController@get_store');
//for unit
Route::get('/unit', 'UnitController@home') ->name('unit');
Route::resource('/unit/units','UnitController');
//for role
Route::get('/role', 'RoleController@home') ->name('role');
Route::resource('/role/roles','RoleController');
//for user
Route::get('/user', 'UserController@home') ->name('user');
Route::resource('/user/users','UserController');
//for patient
Route::get('/patient', 'PatientController@home') ->name('patient');
Route::resource('/patient/patients','PatientController');
//for metadata
Route::get('/metadata', 'MetadataController@home') ->name('metadata');
Route::resource('/metadata/metadatas','MetadataController');
//for normal
Route::get('/normal', 'NormalController@home') ->name('normal');
Route::resource('/normal/normals','NormalController');
//for location
Route::get('/location', 'LocationController@home') ->name('location');
Route::resource('/location/locations','LocationController');
//for type
Route::get('/type', 'TypeController@home') ->name('type');
Route::resource('/type/types','TypeController');


