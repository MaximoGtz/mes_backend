<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilerController;
use App\Http\Controllers\InsertionController;

Route::get("/profiler/card/{id}", [ProfilerController::class, "getProfiler"]);
//This method automatically takes all the crud methods, index, create, store, show, update, destroy
Route::apiResource("/profilers", ProfilerController::class);
Route::apiResource('/insertions', InsertionController::class);