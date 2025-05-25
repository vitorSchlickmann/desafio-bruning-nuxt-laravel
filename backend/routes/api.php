<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColaboradorController;

Route::get('/colaboradores/proximo-codigo', [ColaboradorController::class, 'proximoCodigo']);

Route::apiResource('colaboradores', ColaboradorController::class);
