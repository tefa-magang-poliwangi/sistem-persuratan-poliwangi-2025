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
Route::group(['middleware' => ['auth', 'permission']], function () {
    Route::prefix('surat')->group(function () {
        Route::get('/surat-masuk', 'SuratController@index');
        Route::put('/surat-masuk/arsip/{id}', 'SuratController@arsip');
        Route::resource('surat-masuk', 'SuratController');
        Route::get('/surat-masuk/lembar-disposisi/{id}', 'SuratController@disposisi');

        Route::get('/arsip', 'ArsipSuratController@index');
        Route::resource('arsip', 'ArsipSuratController');

        Route::get('/wadir', 'WadirController@index');
        Route::get('/wadir/detail/{id}', 'WadirController@detail');
        Route::resource('wadir', 'WadirController');
        Route::patch('/wadir/updateDisposisi/{id}', 'WadirController@updateDisposisi');

        Route::get('/disposisi-surat', 'DisposisiSuratController@index');
        Route::get('/disposisi-surat/editDisposisi/{id}', 'DisposisiSuratController@editDisposisi');
        Route::patch('/disposisi-surat/updateDisposisi/{id}', 'DisposisiSuratController@updateDisposisi');
        Route::get('/disposisi-surat/detail/{id}', 'DisposisiSuratController@detail');
        Route::resource('disposisi-surat', 'DisposisiSuratController');
    });
});
