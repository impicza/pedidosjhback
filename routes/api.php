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
    Route::get('/users/estado/{id}/{cambio}', 'UserController@estado')->middleware('isAdmin');
    Route::get('/users/reinitpassword/{id}', 'UserController@reiniciarPassword')->middleware('isAdmin');
    Route::post('/users/changepassword', 'AuthController@changePassword')->middleware('isAdminOrSelf');
});

Route::group(['prefix' => 'generales', 'middleware' => 'auth'], function(){
    Route::apiResource('grupos', 'GruposController')->except(['store','index']);
    Route::apiResource('unidades', 'UnidadesController')->except(['store','index']);
    Route::apiResource('productos', 'ProductosController')->except(['store','index']);
    Route::get('grupos/estado/activos', 'GruposController@indexActivos');
    Route::get('unidades/estado/activos', 'UnidadesController@indexActivos');
    Route::get('productos/estado/activos', 'ProductosController@indexActivos');
});

Route::group(['prefix' => 'generales', 'middleware' => ['auth','isAdmin']], function(){
    Route::post('grupos', 'GruposController@store');
    Route::post('unidades', 'UnidadesController@store');
    Route::post('productos', 'ProductosController@store');
    Route::get('grupos', 'GruposController@index');
    Route::get('unidades', 'UnidadesController@index');
    Route::get('productos', 'ProductosController@index');
    Route::get('grupos/estado/{id}/{cambio}', 'GruposController@estado');
    Route::get('unidades/estado/{id}/{cambio}', 'UnidadesController@estado');
    Route::get('productos/estado/{id}/{cambio}', 'ProductosController@estado');
});

Route::group(['prefix' => 'pedidos', 'middleware' => 'auth'], function(){
    Route::apiResource('items', 'PedidosController');
    Route::get('listadoporcliente/{id}', 'PedidosController@listadoPorCliente');
    Route::get('listadocompleto', 'PedidosController@listadoCompleto');
    Route::get('imprimirpedidocliente/{id}', 'PedidosController@imprimirPedidoCliente');
    Route::get('imprimirpedido/{id}', 'PedidosController@imprimirPedido')->middleware('isAdmin');
    Route::get('estado/reactivar/{id}', 'PedidosController@reactivar')->middleware('isAdmin');
});




