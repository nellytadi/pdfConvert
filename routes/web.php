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


Route::get('/main/app', 'MainController@create')->name('main.app');
Route::post('main/app/store','MainController@store')->name('main.app.store');
//'main.app.store.answer'
Route::get('main/app/store/answer','MainController@answer')->name('main.app.store.answer');
