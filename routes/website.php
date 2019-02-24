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

Route::get('/historische-personen', 'Website\PersonsController@index')->name('website.persons.index');
Route::get('/historische-personen/{slug}', 'Website\PersonsController@show')->name('website.persons.show');
