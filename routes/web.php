<?php

use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ExamQuestionController;
use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\CustomFieldController;
use App\Http\Controllers\DashboardPayment;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\UserDashboard;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistrationPeriod;


Route::get('/', function () {
  return view('welcome');
})->name('welcome');

Route::get('/pembuka', function () {
  return view('pembuka');
})->middleware(['auth', 'verified'])->name('pembuka');

Route::get('/cek-verifikasi', function () {
  /** @var \App\Models\User $user */
  $user = Auth::user();

  // Eager load semua relasi terkait verifikasi
  $user->load(['validity', 'payment', 'document']);

  return view('camaba.verifikasi.index', [
    'user' => $user,
    'validity' => $user->validity
  ]);
})->middleware(['auth', 'verified'])->name('verifikasi.index');

Route::get('/cek-pembayaran', function () {
  /** @var \App\Models\User $user */
  $user = Auth::user();

  if ($user) {
    // Load payment dan validity sekaligus
    $user->load(['payment', 'validity']);
  }

  return view('payments.index', [
    'user' => $user,
    'payment' => $user?->payment,
    'validity' => $user?->validity // Tambahkan ini agar bisa diakses di view
  ]);
})->middleware(['auth', 'verified'])->name('pembayaran.status');

Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('/formulir', function () {
    return view('camaba.formulir.index');
  })->name('formulir');

  Route::get('/formulir/isi-form', [FormController::class, 'createIdentity'])->name('isi-formulir');
  Route::get('/formulir/isi-form/upload-dokumen', [FormController::class, 'createDocuments'])->name('isi-dokumen');

  // routes/web.php
  Route::get('/formulir/pembayaran', function () {
    $user = Auth::user();

    // Ambil data hanya berdasarkan status aktif (abaikan filter jam dulu)
    $activeWave = RegistrationPeriod::where('is_active', true)->first();

    return view('camaba.formulir.payment', [
      'activeWave' => $activeWave,
      'user' => $user,
      'payment' => $user?->payment,
      'validity' => $user?->validity,
    ]);
  })->middleware(['auth', 'verified'])->name('formulir.pembayaran');



  Route::get('/exams', [App\Http\Controllers\Student\ExamController::class, 'index'])->name('exams.index');

  // Masuk ke ruang ujian (Ngerjain soal)
  Route::get('/exams/{exam}', [App\Http\Controllers\Student\ExamController::class, 'show'])->name('exams.show');

  // Tombol buat kirim semua jawaban
  Route::post('/exams/{exam}/submit', [App\Http\Controllers\Student\ExamController::class, 'store'])->name('exams.store');


  Route::post('/formulir/isi-form', [FormController::class, 'storeIdentity'])->name('form.store');
  Route::post('/formulir/isi-form/upload-dokumen', [FormController::class, 'storeDocuments'])->name('dokumen.store');
  Route::post('/formulir/pembayaran', [FormController::class, 'storePayment'])->name('payment.store');
});

Route::middleware(['auth', 'verified', 'admin'])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {
    Route::get('/dashboard', function () {
      return view('admin.dashboard.index');
    })->name('dashboard');

    Route::get('/dashboard/list-pendaftar', [UserDashboard::class, 'pendaftar'])->name('dashboard.pendaftar');

    Route::patch('/pembayaran/{id}', [DashboardPayment::class, 'updateStatus'])->name('pembayaran.update');

    Route::get('/dashboard/list-pendaftar/pendaftar/{id}', [UserDashboard::class, 'show'])->name('dashboard.pendaftar.show');

    Route::post('/pendaftar/list-pendaftar/pendaftar/{id}/validate', [UserDashboard::class, 'validateData'])
      ->name('pendaftar.validate');
    Route::post('/pendaftar/list-pendaftar/pendaftar/{id}/cancel', [UserDashboard::class, 'cancelValidation'])
      ->name('pendaftar.cancel');
    Route::get('/dashboard/pembayaran', [DashboardPayment::class, 'index'])->name('pembayaran');

    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');


    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/create', [ExamController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');

    Route::get('/exams/monitoring', [ExamController::class, 'monitoring'])->name('exams.monitoring');

    Route::get('/exams/{exam}', [ExamController::class, 'show'])->name('exams.show');

    Route::get('/exams/{exam}/questions/create', [ExamQuestionController::class, 'create'])->name('exams.questions.create');
    Route::post('/exams/{exam}/questions', [ExamQuestionController::class, 'store'])->name('exams.questions.store');
    Route::get('/exams/{exam}/questions/{question}/edit', [ExamQuestionController::class, 'edit'])->name('exams.questions.edit');
    Route::put('/exams/{exam}/questions/{question}', [ExamQuestionController::class, 'update'])->name('exams.questions.update');
    Route::delete('/exams/{exam}/questions/{question}', [ExamQuestionController::class, 'destroy'])->name('exams.questions.destroy');
    Route::delete('/exams/{exam}', [App\Http\Controllers\Admin\ExamController::class, 'destroy'])->name('exams.destroy');

    Route::prefix('admission')->name('admission.')->group(function () {
      // Dashboard & Laporan Statistik
      Route::get('/dashboard', [AdmissionController::class, 'dashboard'])->name('dashboard');

      // Pengaturan Program Studi
      Route::get('/study-programs', [AdmissionController::class, 'programIndex'])->name('programs.index');
      Route::post('/study-programs', [AdmissionController::class, 'programStore'])->name('programs.store');
      Route::delete('/study-programs/{id}', [AdmissionController::class, 'programDestroy'])->name('programs.destroy');

      // Pengaturan Periode/Gelombang
      Route::get('/periods', [AdmissionController::class, 'periodIndex'])->name('periods.index');
      Route::post('/periods', [AdmissionController::class, 'periodStore'])->name('periods.store');
      Route::patch('/periods/{id}/toggle', [AdmissionController::class, 'periodToggle'])->name('periods.toggle');
      Route::delete('/periods/{id}', [AdmissionController::class, 'periodDestroy'])->name('periods.destroy');
      Route::put('/periods/{id}', [AdmissionController::class, 'update'])->name('periods.update');
    });

    Route::prefix('custom-fields')->name('custom-fields.')->group(function () {
      Route::get('/', [CustomFieldController::class, 'index'])->name('index');
      Route::post('/', [CustomFieldController::class, 'store'])->name('store');
      Route::delete('/{customField}', [CustomFieldController::class, 'destroy'])->name('destroy');

      // Tambahan jika Anda ingin fitur update nantinya
      Route::put('/{customField}', [CustomFieldController::class, 'update'])->name('update');

      // Route untuk mengatur urutan (optional)
      Route::post('/reorder', [CustomFieldController::class, 'reorder'])->name('reorder');
    });
  });

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
