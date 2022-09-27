<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function() {
    Route::post('login', ['as' => 'api.login', 'uses' => 'App\Http\Controllers\Auth\Api\ApiLoginController@login']);
    Route::post('logout', ['as' => 'api.logout', 'uses' => 'App\Http\Controllers\Auth\Api\ApiLoginController@logout']);
});

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('sistema')->group(function() {
        /* Usuário */
        Route::resource('usuario', 'App\Http\Controllers\UserController', ['parameters' => ['' => 'id']]);
        Route::put('usuario/modo_escuro/{id}', ['as' => 'usuario.modo_escuro', 'uses' => 'App\Http\Controllers\UserController@alteraModoEscuro']);

        /* Sala de Aula */
        Route::resource('sala_aula', 'App\Http\Controllers\SalaController', ['parameters' => ['' => 'id']]);

        /* Aula */
        Route::resource('aula', 'App\Http\Controllers\AulaController', ['parameters' => ['' => 'id']]);
        Route::get('aulas_reservadas', 'App\Http\Controllers\AulaController@getClassDay');

        /* Intervencao */
        Route::resource('intervencao', 'App\Http\Controllers\IntervencaoController', ['parameters' => ['' => 'id']]);
    });
});
