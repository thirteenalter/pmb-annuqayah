<?php

use App\Http\Controllers\Admin\StudentFormController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportSummary;

Route::get('camaba/edit/{id}', [StudentFormController::class, 'show'])
  ->whereNumber('id')
  ->name('pendaftar.edit.show');



Route::resource('report', ReportSummary::class)->names('reportsum')->only(['index', 'export']);
Route::get('export/data', [ReportSummary::class, 'export'])
  ->name('reports');
Route::get('export/master-data', [ReportSummary::class, 'exportMaster'])->name('report.master');
