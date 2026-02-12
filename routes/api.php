<?php

use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\StudentAdmissionReportController;
use Illuminate\Support\Facades\Route; // Gunakan Facade ini

Route::middleware(['auth.apikey'])->group(function () {
  Route::get('/users-pmb', [StudentAdmissionReportController::class, 'index']);
});

Route::get('/regions/{id}', [RegionController::class, 'getByParent']);
