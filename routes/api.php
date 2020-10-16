<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('users', 'App\Http\Controllers\UserController@add');
// Route::get('users', 'App\Http\Controllers\UserController@all');
// Route::post('usersMultiple', 'App\Http\Controllers\UserController@addMultiple');
// Route::put('users/{id}', 'App\Http\Controllers\UserController@updateUser');
// Route::get('users/{id}', 'App\Http\Controllers\UserController@getUser');
// Route::get('user-groups', 'App\Http\Controllers\UserController@getMultipleUsers');
// Route::get('user-regex', 'App\Http\Controllers\UserController@regex');
// Route::put('update-all', 'App\Http\Controllers\UserController@updateAll');
// Route::put('replace/{id}', 'App\Http\Controllers\UserController@replace');
// Route::post('upsert', 'App\Http\Controllers\UserController@upsert');
// Route::delete('delete/{id}', 'App\Http\Controllers\UserController@delete');
// Route::delete('delete-all', 'App\Http\Controllers\UserController@deleteAll');


// Route::post('contracts', 'App\Http\Controllers\DepartmentController@add');
// Route::get('contracts', 'App\Http\Controllers\DepartmentController@find');
// Route::put('contracts-find-update/{id}', 'App\Http\Controllers\DepartmentController@findOneAndUpdate');

Route::resource('writings', 'App\Http\Controllers\Package\WritingController');
Route::resource('users', 'App\Http\Controllers\Package\UserController');
Route::resource('departments', 'App\Http\Controllers\Package\DepartmentController');
Route::delete('writings/{writing}/users/{user}', 'App\Http\Controllers\Package\WritingController@detach');
Route::get('writings/{writing}/users/', 'App\Http\Controllers\Package\WritingController@getUsers');


// Route::resource('users', 'App\Http\Controllers\Native\UserController');
// Route::resource('departments', 'App\Http\Controllers\Native\DepartmentController');
