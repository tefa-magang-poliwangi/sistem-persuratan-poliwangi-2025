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

Route::prefix('jabatan')->group(function() {
    Route::prefix('data-jabatan')->group(function() {
        Route::get('/', 'JabatanController@index');
    });
    Route::resource('data-jabatan', 'JabatanController');
});
