<?php

use App\Http\Controllers\Admin\StudentFormController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportSummary;
use Illuminate\Support\Facades\Artisan;


Route::get('camaba/edit/{id}', [StudentFormController::class, 'show'])
  ->whereNumber('id')
  ->name('pendaftar.edit.show');
Route::post('camaba/edit/{id}', [StudentFormController::class, 'store'])
  ->whereNumber('id')
  ->name('pendaftar.edit.store');

Route::get('setup-storage', function () {
  Artisan::call('storage:link');
  return "Symlink berhasil diperbarui oleh Admin!";
});

Route::get('fix-storage', function () {
  $link = public_path('storage');
  if (file_exists($link)) {
    app('files')->delete($link);
  }

  Artisan::call('storage:link');
  return "Symlink sudah diperbarui!";
});


Route::resource('report', ReportSummary::class)->names('reportsum')->only(['index', 'export']);
Route::get('export/data', [ReportSummary::class, 'export'])
  ->name('reports');
Route::get('export/master-data', [ReportSummary::class, 'exportMaster'])->name('report.master');
