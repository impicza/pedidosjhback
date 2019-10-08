<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
});

Route::group(['prefix' => 'generales', 'middleware' => 'auth'], function(){
    Route::apiResource('grupos', 'GruposController')->except('store');
    Route::apiResource('unidades', 'UnidadesController')->except('store');
    Route::apiResource('productos', 'ProductosController')->except('store');
});

Route::group(['prefix' => 'generales', 'middleware' => ['auth','isAdmin']], function(){
    Route::post('grupos', 'GruposController@store');
    Route::post('unidades', 'UnidadesController@store');
    Route::post('productos', 'ProductosController@store');
});

Route::group(['prefix' => 'pedidos', 'middleware' => 'auth'], function(){
    Route::apiResource('items', 'PedidosController');
    Route::get('listadoporcliente/{id}', 'PedidosController@listadoPorCliente');
    Route::get('listadocompleto', 'PedidosController@listadoCompleto');
    Route::get('imprimirpedido/{id}', 'PedidosController@imprimirPedido');
});

