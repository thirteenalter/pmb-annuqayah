<?php

use App\Http\Controllers\Api\StudentAdmissionReportController;
use Illuminate\Support\Facades\Route; // Gunakan Facade ini

Route::middleware(['auth.apikey'])->group(function () {
  Route::get('/users-pmb', [StudentAdmissionReportController::class, 'index']);
});
