<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColaboradorController;

Route::apiResource('colaboradores', ColaboradorController::class);

Route::get('colaboradores/proximo-codigo', function () {
    $ultimo = \App\Models\Colaborador::max('codigo');
    $proximo = is_numeric($ultimo) ? $ultimo + 1 : 1;
    return response()->json(['proximo_codigo' => $proximo]);
});
