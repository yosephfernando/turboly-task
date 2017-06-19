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
Route::resource('/users-manage', 'UsersController', ['except' => ['create', 'store', 'edit']]);
Route::get('/users-data', 'UsersController@listUsersData')->name('users-data');
Route::post('/logout', 'UsersController@performLogout')->name('logout');

Route::resource('/tasks', 'TasksController', ['except' => ['create', 'edit']]);
Route::get('/tasks-data', 'TasksController@listTasksData')->name('tasks-data');
