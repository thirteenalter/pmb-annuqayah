<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\RegistrationPeriod;
use App\Models\User;
use App\Models\Validity;
use Illuminate\Support\Facades\DB;

class UserDashboard extends Controller
{
  public function pendaftar(Request $request)
  {
    $search = $request->input('search');
    $waveFilter = $request->input('wave_id');

    $users = User::with(['registration', 'registrationPeriod', 'payment'])
      ->where('role', 'user')
      ->when($search, function ($query) use ($search) {
        $query->where(function ($q) use ($search) {
          $q->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhereHas('registration', function ($reg) use ($search) {
              $reg->where('participant_number', 'like', "%{$search}%")
                ->orWhere('school_origin', 'like', "%{$search}%");
            });
        });
      })
      ->when($waveFilter, function ($query) use ($waveFilter) {
        $query->where('registration_period_id', $waveFilter);
      })
      ->latest()
      ->paginate(15)
      ->withQueryString();

    $waves = RegistrationPeriod::all();

    return view('admin.pendaftar.index', compact('users', 'waves'));
  }

  public function show($id)
  {
    // Mengambil data user beserta seluruh relasi sesuai model yang Anda berikan
    $user = User::with([
      'identity',     // Dari model Identity.php
      'registration', // Dari model Registration.php
      'document',     // Dari model Document.php
      'payment',      // Dari model Payment.php
      'validity',     // Dari model Validity.php
      'registrationPeriod', // Dari model RegistrationPeriod.php
      'studentDetail',
      'examSessions',
      'customFieldValues.customField' // Relasi untuk custom fields

    ])->findOrFail($id);

    return view('admin.pendaftar.show', compact('user'));
  }

  public function validateData(Request $request, $id)
  {
    return DB::transaction(function () use ($request, $id) {
      // Gunakan firstOrNew agar tidak error jika data payment belum ada
      $user = User::findOrFail($id);
      $payment = Payment::firstOrNew(['user_id' => $id]);
      $validity = Validity::firstOrNew(['user_id' => $id]);

      // 1. Validasi Identitas
      if ($request->has('set_data')) {
        $validity->is_data_valid = ($request->set_data === 'valid');
      }

      // 2. Validasi Pembayaran (SINKRONKAN DI SINI)
      if ($request->has('set_payment')) {
        $status = $request->set_payment; // 'valid' atau 'invalid'
        $validity->is_payment_valid = ($status === 'valid');

        // Update juga kolom status di tabel payments
        $payment->status = $status;
        $payment->save();
      }

      // 3. Keputusan Kelulusan (Tabel registrations)
      if ($request->has('set_graduation')) {
        Registration::where('user_id', $id)->update([
          'status_kelulusan' => $request->set_graduation
        ]);
      }

      // 4. Verifikasi Data Final (Tabel users & validities)
      if ($request->has('final_status')) {
        $status = $request->final_status;
        $validity->final_status = $status;

        User::where('id', $id)->update(['status' => $status]);

        if ($status === 'valid') {
          $validity->is_data_valid = true;
          $validity->is_payment_valid = true;
          $user->status = 'valid';
          $user->save();
          $payment->status = 'success';
          $payment->save();
        }
      }

      if ($request->has('admin_note')) {
        $validity->admin_note = $request->admin_note;
      }

      $validity->verified_at = now();
      $validity->save();

      return back()->with('success', 'Perubahan berhasil disimpan.');
    });
  }

  public function cancelValidation($id)
  {
    return DB::transaction(function () use ($id) {
      // Reset tabel validity
      Validity::where('user_id', $id)->update([
        'is_data_valid'    => 0,
        'is_payment_valid' => 0,
        'final_status'     => 'pending',
        'verified_at'      => null,
        'admin_note'       => null
      ]);

      // Reset tabel users
      User::where('id', $id)->update(['status' => 'pending']);

      return back()->with('success', 'Seluruh validasi telah dibatalkan.');
    });
  }
}
