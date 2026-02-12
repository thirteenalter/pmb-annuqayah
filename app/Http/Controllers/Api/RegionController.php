<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataWilayah;
use Illuminate\Http\Request;

class RegionController extends Controller
{
  public function getByParent($id)
  {
    $data = DataWilayah::where('id_induk_wilayah', $id)
      ->orderBy('nm_wil', 'asc')
      ->get();

    return response()->json($data);
  }
}
