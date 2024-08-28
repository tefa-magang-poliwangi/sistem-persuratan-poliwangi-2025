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
    Route::get('/dashboard', 'DashboardController@index');
    Route::prefix('surat')->group(function () {
        Route::get('/surat-masuk', 'SuratController@index');
        Route::get('/surat-masuk/diagram/{id}', 'SuratController@diagram')->name('surat-masuk.diagram');
        Route::put('/surat-masuk/arsip/{id}', 'SuratController@arsip')->name('surat-masuk.arsip');
        Route::put('/surat-masuk/selesai/{id}', 'SuratController@selesai')->name('surat-masuk.selesai');
        Route::get('/surat-masuk/detail/{id}', 'SuratController@detail')->name('surat-masuk.detail');
        Route::patch('/surat-masuk/disposisi/{id}', 'SuratController@disposisiSurat')->name('surat-masuk.disposisi');
        Route::resource('surat-masuk', 'SuratController');
        Route::get('/surat-masuk/lembar-disposisi/{id}', 'SuratController@disposisi')->name('surat-masuk.lembar-disposisi');
        Route::post('/surat-masuk/acc/{id}', 'SuratController@acc')->name('surat-masuk.acc');

        Route::get('/arsip', 'ArsipSuratController@index');
        Route::resource('arsip', 'ArsipSuratController');

        Route::get('/wadir', 'WadirController@index');
        Route::get('/wadir/detail/{id}', 'WadirController@detail')->name('wadir.detail');
        Route::resource('wadir', 'WadirController');
        Route::patch('/wadir/updateDisposisi/{id}', 'WadirController@updateDisposisi')->name('wadir.update-disposisi');
        Route::post('/wadir/acc/{id}', 'WadirController@acc')->name('wadir.acc');

        Route::get('/disposisi-surat', 'DisposisiSuratController@index');
        Route::get('/disposisi-surat/editDisposisi/{id}', 'DisposisiSuratController@editDisposisi')->name('disposisi-surat.edit-disposisi');;
        Route::patch('/disposisi-surat/updateDisposisi/{id}', 'DisposisiSuratController@updateDisposisi')->name('disposisi-surat.update-disposisi');
        Route::get('/disposisi-surat/detail/{id}', 'DisposisiSuratController@detail')->name('disposisi-surat.detail');

        Route::resource('disposisi-surat', 'DisposisiSuratController');
    });
});
