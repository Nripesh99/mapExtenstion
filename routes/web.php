<?php

use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/map', [MapController::class, 'index']);
Route::post('/find-shortest-path', [MapController::class, 'findShortestPath']);