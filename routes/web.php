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

Auth::routes();

Route::get('/', 'PageController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('user/{id}/', 'PageController@user');
Route::get('search/{id}/', 'PageController@search');

Route::resource('forums', 'ForumController');
Route::resource('thread', 'ThreadController');
Route::resource('post', 'PostController');

Route::get('admin', 'AdminController@index');
Route::get('admin/users', 'AdminController@userIndex');
Route::get('admin/users/edit/{id}', 'AdminController@userEdit');
Route::get('admin/users/create', 'AdminController@userCreate');
Route::post('admin/users', 'AdminController@userStore');
Route::put('admin/users/{id}', 'AdminController@userUpdate');
Route::delete('admin/users/{id}', 'AdminController@userDestroy');
