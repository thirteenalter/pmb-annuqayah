<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use App\Models\RegistrationPeriod;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdmissionController extends Controller
{
  // --- DASHBOARD & LAPORAN ---
  public function dashboard()
  {
    // Statistik Ringkas (Cek model User dan Validity)
    $stats = [
      'total_pendaftar' => User::where('role', 'user')->count(),
      'total_lunas' => DB::table('validities')->where('is_payment_valid', true)->count(),
      'total_terverifikasi' => DB::table('validities')->where('final_status', 'valid')->count(),
    ];

    // Laporan per Program Studi (Data untuk Tabel/Grafik)
    $prodiStats = StudyProgram::withCount('registrations')->get();

    // Laporan per Gelombang
    $periodStats = RegistrationPeriod::withCount('registrations')->get();

    return view('admin.admission.dashboard', compact('stats', 'prodiStats', 'periodStats'));
  }

  // --- MANAJEMEN PROGRAM STUDI ---
  public function programIndex()
  {
    $programs = StudyProgram::orderBy('faculty')->get();
    return view('admin.admission.programs', compact('programs'));
  }

  public function programStore(Request $request)
  {
    $request->validate([
      'name' => 'required|unique:study_programs,name',
      'faculty' => 'nullable|string'
    ]);

    StudyProgram::create($request->all());
    return back()->with('success', 'Program Studi berhasil ditambahkan.');
  }

  public function programDestroy($id)
  {
    StudyProgram::findOrFail($id)->delete();
    return back()->with('success', 'Program Studi berhasil dihapus.');
  }

  public function periodIndex()
  {
    $periods = RegistrationPeriod::orderBy('start_date', 'desc')->get();

    // Ambil data user yang sedang login
    $user = auth()->user();

    return view('admin.admission.periods', compact('periods', 'user'));
  }

  public function periodStore(Request $request)
  {
    $data = $request->validate([
      'name' => 'required',
      'price' => 'required|numeric',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after:start_date',
    ]);

    RegistrationPeriod::create($data);
    return back()->with('success', 'Gelombang pendaftaran berhasil dibuat.');
  }

  public function periodToggle($id)
  {
    $period = RegistrationPeriod::findOrFail($id);
    $period->update(['is_active' => !$period->is_active]);
    return back()->with('success', 'Status gelombang berhasil diubah.');
  }

  public function update(Request $request, $id)
  {
    $data = $request->validate([
      'name' => 'required|string',
      'price' => 'required|numeric',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after:start_date',
    ]);

    $period = RegistrationPeriod::findOrFail($id);
    $period->update($data);

    return back()->with('success', 'Data gelombang berhasil diperbarui.');
  }
}
