<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CarroController,
    SucursalController,
    ReservaController,
    PagoController,
    CarroFotoController,
};
use App\Http\Controllers\API\AuthController;

// RUTAS PÚBLICAS (NO necesitan token)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// RUTAS PROTEGIDAS POR SANCTUM
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Recursos principales
    Route::apiResource('sucursales', SucursalController::class);
    Route::apiResource('carros',     CarroController::class);
    Route::apiResource('reservas',   ReservaController::class);
    Route::apiResource('pagos',      PagoController::class)->only(['index','store','show','destroy','update']);

    // Fotos de carros
    Route::get   ('carros/{carro}/fotos',                [CarroFotoController::class, 'index']);
    Route::post  ('carros/{carro}/fotos',                [CarroFotoController::class, 'store']);
    Route::delete('carros/{carro}/fotos/{foto}',         [CarroFotoController::class, 'destroy']);
    Route::patch ('carros/{carro}/fotos/{foto}/principal', [CarroFotoController::class, 'setPrincipal']);

    // Manejo de carros dentro de reservas
    Route::post  ('reservas/{reserva}/carros',         [ReservaController::class, 'attachCarros']);
    Route::delete('reservas/{reserva}/carros/{carro}', [ReservaController::class, 'detachCarro']);
    Route::post  ('reservas/{reserva}/recalcular',     [ReservaController::class, 'recalcular']);
});
