<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColaboradorController;

Route::middleware('api')->group(function() {
    Route::apiResource('colaboradores', ColaboradorController::class);
});
