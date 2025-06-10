<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilerController;
use App\Http\Controllers\InsertionController;
use App\Http\Controllers\JustificationController;

Route::get("/profiler/card/{id}", [ProfilerController::class, "getProfiler"]);
//This method automatically takes all the crud methods, index, create, store, show, update, destroy
Route::apiResource("/profilers", ProfilerController::class);
Route::apiResource('/insertions', InsertionController::class);
// Route::get("/profilers/insertions/{id}", [ProfilerController::class, "getInsertions"]);
Route::get("/insertions/table/show", [InsertionController::class, "getInsertionsTable"]);
Route::post("/agregar_justificacion", [JustificationController::class, "makeJustification"]);
Route::get("/obtener_justificaciones/dia", [JustificationController::class, "getJustificationsDay"]);