<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColaboradorController;

Route::middleware('api')->group(function () {
    Route::apiResource('colaboradores', ColaboradorController::class)->parameters([
        'colaboradores' => 'id'
    ]);
});
