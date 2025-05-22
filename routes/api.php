<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilerController;
use App\Http\Controllers\InsertionController;

Route::get("/test", [ProfilerController::class, "testRoute"]);
Route::get("/insertions", [InsertionController::class, "getAll"]);
Route::get("/profiler/{id}", [ProfilerController::class, "getProfiler"]);
