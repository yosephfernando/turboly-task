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
Route::get('/users', 'UsersController@listUsers')->name('users');
Route::get('/users-data', 'UsersController@listUsersData')->name('users-data');
//Route::get('/users-search/{keyword}', 'UsersController@listUsersSearch')->name('users-serach');
Route::get('/users-update/{idUser}', 'UsersController@updateUser')->name('users-update');
Route::post('/users-update-action', 'UsersController@updateUserAction')->name('users-update-action');
Route::post('/users-delete', 'UsersController@deleteUser')->name('users-delete');
Route::post('/logout', 'UsersController@performLogout')->name('logout');

Route::get('/tasks', 'TasksController@listTasks')->name('tasks');
Route::get('/tasks-data', 'TasksController@listTasksData')->name('tasks-data');
Route::post('/tasks-add', 'TasksController@addTasksAction')->name('tasks-add');
Route::get('/tasks-filter/{date}/{prior}', 'TasksController@listTasksFilter')->name('tasks-filter');
Route::get('/tasks-search/{keyword}', 'TasksController@listTasksSearch')->name('tasks-search');
Route::post('/tasks-update-status', 'TasksController@updateTasksStatus')->name('tasks-status-update');
