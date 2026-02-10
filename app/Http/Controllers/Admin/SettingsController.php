<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function showSettingsPublicImage($path)
  {
    // $path sudah berisi "settings/namafile.jpg" dari database
    $fullPath = storage_path('app/public/' . $path);

    if (!file_exists($fullPath)) {
      abort(404, "File tidak ditemukan di: " . $fullPath);
    }

    // Pastikan server mengirimkan file dengan benar
    return response()->file($fullPath);
  }

  public function index()
  {
    $rekening = Settings::select('rekening', 'nama_rekening', 'nama_bank', 'nowa', 'thumb1', 'thumb2', 'thumb3')->first()
      ?? (object) [
        'rekening' => null,
        'nama_bank' => null,
        'nama_rekening' => null,
        'nowa' => null,
        'thumb1' => null,
        'thumb2' => null,
        'thumb3' => null,
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
      'thumb1'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
      'thumb2'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
      'thumb3'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $settings = Settings::find(1) ?? new Settings();

    $data = [
      'rekening'      => $request->rekening,
      'nama_bank'     => $request->nama_bank,
      'nama_rekening' => $request->nama_rekening,
      'nowa'          => $request->nowa,
    ];

    for ($i = 1; $i <= 3; $i++) {
      $key = 'thumb' . $i;
      if ($request->hasFile($key)) {
        if ($settings->$key && Storage::disk('public')->exists($settings->$key)) {
          Storage::disk('public')->delete($settings->$key);
        }

        $path = $request->file($key)->store('settings', 'public');
        $data[$key] = $path;
      }
    }

    Settings::updateOrCreate(['id' => 1], $data);

    return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
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
