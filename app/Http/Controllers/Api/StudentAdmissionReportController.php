<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class StudentAdmissionReportController extends Controller
{
  public function index(Request $request)
  {
    $users = User::with([
      'identity',
      'validity',
      'registration.studentDetails', // Gunakan nama yang ada di model Registration
      'registration.studentFamily',
      'registration.studyProgram'
    ])->paginate($request->get('limit', 10));

    return response()->json([
      'status'  => 'success',
      'message' => 'List Data PMB',
      'payload' => $users
    ], 200);
  }
}
