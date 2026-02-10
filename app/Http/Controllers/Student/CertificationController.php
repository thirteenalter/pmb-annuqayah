<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificationController extends Controller
{
  public function index()
  {
    // kelulusan cbt, administrasi, pembayaran, da
    $user = Auth::user();

    if ($user) {
      $user->load(['validity']);
    }

    return view("camaba.verifikasi.cert", compact('user'));
  }
}
