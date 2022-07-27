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

Route::group(['middleware' => ['auth']], function () {
    Route::get('token', ['as' => 'api.token', 'uses' => 'App\Http\Controllers\Auth\Api\ApiLoginController@returnToken']);

    Route::get('/', function () {
        return view('modulos.principal');
    })->name('index');

    Route::prefix('sistema')->name('sistema.')->group(function () {
        Route::get('/{vue?}', function () {
            return view('modulos.sistema');
        })->where(['vue' => '.*'])->name('index');
    });

    Route::prefix('clinica')->name('clinica.')->group(function () {
        Route::get('/{vue?}', function () {
            return view('modulos.clinica');
        })->where(['vue' => '.*'])->name('index');
    });
});

require __DIR__.'/auth.php';
