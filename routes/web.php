<?php

use Illuminate\Support\Facades\Route;

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
Route::resource('topics', 'TopicController')->except(['store']);
Route::resource('comments', 'CommentController')->except(['store']);
// Route::get('/topics/create','TopicController@create')->name('topics.create');
Route::post('/topics','TopicController@store')->name('topics.store');
// Route::put('/topics/{user}', 'TopicController@update')->name('topics.update');

 Route::post('/comments','CommentController@store')->name('comments.store');
