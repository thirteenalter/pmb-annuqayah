<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificationController extends Controller
{
  public function index()
  {
    $user = Auth::user()->load(['registration', 'registration.studentDetails']);

    return view("camaba.verifikasi.cert", compact('user'));
  }
}
