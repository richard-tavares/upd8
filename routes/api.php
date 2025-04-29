<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\RepresentativesController;

Route::prefix('v1')->group(function () {
    Route::get('/cities/get-states', [CitiesController::class, 'getStates']);
    Route::get('/cities/get-cities-by-state/{state}', [CitiesController::class, 'getCitiesByState']);
    Route::get('/clients/get-states-from-clients', [ClientsController::class, 'getStatesFromClients']);
    Route::get('/representatives/get-states-from-representatives', [RepresentativesController::class, 'getStatesFromRepresentatives']);

    Route::apiResource('cities', CitiesController::class);
    Route::apiResource('clients', ClientsController::class);
    Route::apiResource('representatives', RepresentativesController::class);
});
