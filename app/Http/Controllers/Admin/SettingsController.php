<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $rekening = Settings::select('rekening', 'nama_rekening', 'nama_bank', 'nowa')->first()
      ?? (object) [
        'rekening' => null,
        'nama_bank' => null,
        'nama_rekening' => null,
        'nowa' => null,
      ];

    return view('admin.settings.index', compact('rekening'));
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
    $request->validate([
      'rekening'      => 'nullable|string',
      'nama_bank'     => 'nullable|string',
      'nama_rekening' => 'nullable|string',
      'nowa'          => 'nullable|string',
    ]);

    Settings::updateOrCreate(
      ['id' => 1], // settings global = 1 row aja
      [
        'rekening'      => $request->rekening,
        'nama_bank'     => $request->nama_bank,
        'nama_rekening' => $request->nama_rekening,
        'nowa'          => $request->nowa,
      ]
    );

    return redirect()->back();
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
