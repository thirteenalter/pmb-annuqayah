<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\CalonMahasiswaExport;
use App\Exports\MasterCalonMahasiswaExport;
use Maatwebsite\Excel\Facades\Excel;


class ReportSummary extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('admin.report.index');
  }
  /**
   * Export laporan calon mahasiswa berdasarkan tipe dan periode ke Excel.
   */
  public function export(Request $request)
  {
    $type = $request->query('type', 'all');
    $periodId = $request->query('period_id');

    // Penamaan file yang lebih dinamis
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
