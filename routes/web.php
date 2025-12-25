<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
  return view('welcome');
})->name('welcome');

Route::get('/pembuka', function () {
  return view('pembuka');
})->middleware(['auth', 'verified'])->name('pembuka');


Route::get('/cek-pembayaran', function () {
  /** @var \App\Models\User $user */


  $user = Auth::user();
  if ($user) {
    $user->load('payment');
  }
  return view('payments.index', [
    'user' => $user,
    'payment' => $user->payment
  ]);
})->middleware(['auth', 'verified'])->name('pembayaran.status');

Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('/formulir', function () {
    return view('camaba.formulir.index');
  })->name('formulir');

  Route::get('/formulir/isi-form', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->identity && $user->registration) {
      return redirect()->back()->with('error', 'Data identitas sudah difinalisasi dan tidak dapat diubah.');
    }

    return view('camaba.formulir.create', [
      'user' => $user
    ]);
  })->name('isi-formulir');

  Route::get('/formulir/isi-form/upload-dokumen', function () {
    /** @var User $user */
    $user = Auth::user();

    // Pastikan user ada (sudah login)
    if ($user) {
      $user->load('document');
    }

    $isLocked = ($user && $user->document) ? true : false;

    return view('camaba.formulir.dokumen', [
      'user' => $user,
      'isLocked' => $isLocked
    ]);
  })->name('isi-dokumen');


  Route::get('/formulir/pembayaran', function () {
    return view('camaba.formulir.payment');
  })->name('formulir.pembayaran');


  Route::get('/formulir/isi-form', function () {
    return view('camaba.formulir.create');
  })->name('isi-formulir');


  // Halaman Pembayaran
  Route::get('/formulir/pembayaran', function () {
    return view('camaba.formulir.payment');
  })->name('formulir.pembayaran');


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
    Route::get('/dashboard/list-pendaftar', function () {
      return view('admin.dashboard.pendaftar.index');
    })->name('dashboard.pendaftar');
  });

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
