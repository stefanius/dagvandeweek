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

Route::middleware([])->as('backend.')->group(function () {
    Route::resource('articles', 'Backend\ArticlesController');
    Route::resource('persons', 'Backend\PersonsController');
});
