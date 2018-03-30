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
Route::get('/post/add-new','PostController@get_store');
//for unit
Route::get('/unit', 'UnitController@home') ->name('unit');
Route::resource('/unit/units','UnitController');
Route::get('/unit/add-new','UnitController@get_store');
//for role
Route::get('/role', 'RoleController@home') ->name('role');
Route::resource('/role/roles','RoleController');
Route::get('/role/add-new','RoleController@get_store');
//for user
Route::get('/user', 'UserController@home') ->name('user');
Route::resource('/user/users','UserController');
//for patient
Route::get('/patient', 'PatientController@home') ->name('patient');
Route::resource('/patient/patients','PatientController');
Route::get('/patient/add-new','PatientController@get_store');
//for metadata
Route::get('/metadata', 'MetadataController@home') ->name('metadata');
Route::resource('/metadata/metadatas','MetadataController');
Route::get('/metadata/add-new','MetadataController@get_store');
//for normal
Route::get('/normal', 'NormalController@home') ->name('normal');
Route::resource('/normal/normals','NormalController');
Route::get('/normal/add-new','NormalController@get_store');



