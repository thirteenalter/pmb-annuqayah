<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\CalonMahasiswaExport;
use App\Exports\MasterCalonMahasiswaExport;
use App\Models\Registration;
use App\Models\RegistrationPeriod;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;


class ReportSummary extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $registrationPeriods = RegistrationPeriod::all();

    $selectedPeriodId = $request->get('period_id')
      ?? RegistrationPeriod::latest()->first()?->id;

    $baseQuery = User::where('registration_period_id', $selectedPeriodId)->whereNotIn('id', [1, 2]);

    $counts = [
      'all' => (clone $baseQuery)->count(),

      'acc' => (clone $baseQuery)
        ->whereHas(
          'validity',
          fn($q) =>
          $q->where('is_data_valid', 1)
        )->count(),

      'pending_acc' => (clone $baseQuery)
        ->whereHas(
          'validity',
          fn($q) =>
          $q->where('is_data_valid', 0)
        )->count(),

      'cbt_done' => (clone $baseQuery)
        ->whereHas(
          'examSession',
          fn($q) =>
          $q->where('status', 'done')
        )->count(),

      'cbt_pending' => (clone $baseQuery)
        ->whereDoesntHave(
          'examSession',
          fn($q) =>
          $q->where('status', 'done')
        )->count(),

      'diterima' => (clone $baseQuery)
        ->whereHas(
          'registration',
          fn($q) =>
          $q->where('status_kelulusan', 'lulus')
        )->count(),

      'tidak_diterima' => (clone $baseQuery)
        ->whereHas(
          'registration',
          fn($q) =>
          $q->where('status_kelulusan', 'tidak_lulus')
        )->count(),
    ];



    return view('admin.report.index', compact(
      'registrationPeriods',
      'selectedPeriodId',
      'counts'
    ));
  }

  /**
   * Export laporan calon mahasiswa berdasarkan tipe dan periode ke Excel.
   */
  public function export(Request $request)
  {
    $type = $request->query('type', 'all');
    $periodId = $request->query('period_id');

    $fileName = "laporan-camaba-{$type}-" . now()->format('Y-m-d') . ".xlsx";

    return Excel::download(new CalonMahasiswaExport($type, $periodId), $fileName);
  }

  public function exportMaster()
  {
    return Excel::download(new MasterCalonMahasiswaExport, 'MASTER-DATA-CAMABA-' . now()->format('d-m-Y') . '.xlsx');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
