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

// routes/api.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PedidoController;

use App\Http\Controllers\UserProfileController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {    

    Route::get('/pedidos', [PedidoController::class, 'listarPedidos']);
    Route::post('/pedidos', [PedidoController::class, 'registrarPedido']);
    Route::put('/pedidos/{id}/por-atender', [PedidoController::class, 'EstadoPorAtender']);
    Route::put('/pedidos/{id}/en-proceso', [PedidoController::class, 'EstadoEnProceso']);
    Route::put('/pedidos/{id}/en-delivery', [PedidoController::class, 'EstadoEnDelivery']);
    Route::put('/pedidos/{id}/recibido', [PedidoController::class, 'EstadoRecibido']);

    Route::get('/pedidos/filtrar', [PedidoController::class, 'filtrarPedidosPorNumero']);

});

Route::middleware('auth:sanctum')->get('/profile', [UserProfileController::class, 'show']);
