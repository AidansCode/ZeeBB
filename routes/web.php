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

Route::get('admin/groups', 'AdminController@groupIndex');
Route::get('admin/groups/edit/{id}', 'AdminController@groupEdit');
Route::get('admin/groups/create', 'AdminController@groupCreate');
Route::post('admin/groups', 'AdminController@groupStore');
Route::put('admin/groups/{id}', 'AdminController@groupUpdate');
Route::delete('admin/groups/{id}', 'AdminController@groupDestroy');

Route::get('admin/forums', 'AdminController@forumIndex');
Route::get('admin/forums/edit/{id}', 'AdminController@forumEdit');
Route::get('admin/forums/create', 'AdminController@forumCreate');
Route::post('admin/forums', 'AdminController@forumStore');
Route::put('admin/forums/{id}', 'AdminController@forumUpdate');
Route::delete('admin/forums/{id}', 'AdminController@forumDestroy');

Route::get('admin/settings', 'AdminController@settingIndex');
Route::put('admin/settings/{id}', 'AdminController@settingUpdate');
