<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CarroController, SucursalController, ReservaController, PagoController, CarroFotoController
};

Route::apiResource('sucursales', SucursalController::class);
Route::apiResource('carros', CarroController::class);
Route::apiResource('reservas', ReservaController::class);
Route::apiResource('pagos', PagoController::class)->only(['index','store','show','destroy','update']);

// Fotos de carros (URLs)
Route::get   ('carros/{carro}/fotos', [CarroFotoController::class, 'index']);
Route::post  ('carros/{carro}/fotos', [CarroFotoController::class, 'store']);
Route::delete('carros/{carro}/fotos/{foto}', [CarroFotoController::class, 'destroy']);
Route::patch ('carros/{carro}/fotos/{foto}/principal', [CarroFotoController::class, 'setPrincipal']);

// Manejo de carros dentro de una reserva (many-to-many)
Route::post  ('reservas/{reserva}/carros', [ReservaController::class, 'attachCarros']);      // adjuntar varios
Route::delete('reservas/{reserva}/carros/{carro}', [ReservaController::class, 'detachCarro']); // quitar uno
Route::post  ('reservas/{reserva}/recalcular', [ReservaController::class, 'recalcular']);      // recalcula total
