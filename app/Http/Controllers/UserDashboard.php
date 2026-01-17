<?php

namespace App\Http\Controllers;

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
      'customFieldValues.customField' // Relasi untuk custom fields
    ])->findOrFail($id);

    return view('admin.pendaftar.show', compact('user'));
  }

  public function validateData(Request $request, $id)
  {
    // Gunakan Transaction untuk keamanan data
    return DB::transaction(function () use ($request, $id) {

      $validity = Validity::firstOrNew(['user_id' => $id]);

      // 1. Validasi Identitas (dari tombol di div Identitas)
      if ($request->has('set_data')) {
        $validity->is_data_valid = ($request->set_data === 'valid');
      }

      // 2. Validasi Berkas/Pembayaran (dari tombol di div Berkas)
      if ($request->has('set_payment')) {
        $validity->is_payment_valid = ($request->set_payment === 'valid');
      }

      // 3. Validasi Universal / Keputusan Akhir
      if ($request->has('final_status')) {
        $status = $request->final_status; // 'valid', 'invalid', atau 'pending'
        $validity->final_status = $status;

        // Sinkronisasi ke tabel Users
        User::where('id', $id)->update(['status' => $status]);

        // Shortcut: Jika "Terima Semua", otomatis centang sub-bagian
        if ($status === 'valid') {
          $validity->is_data_valid = true;
          $validity->is_payment_valid = true;
        }
      }payment

      // 4. Catatan Admin
      if ($request->has('admin_note')) {
        $validity->admin_note = $request->admin_note;
      }

      // Set waktu verifikasi setiap ada perubahan
      $validity->verified_at = now();
      $validity->save();

      return back()->with('success', 'Status verifikasi pendaftar berhasil diperbarui.');
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
