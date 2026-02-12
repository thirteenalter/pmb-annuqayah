<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class StudentAdmissionReportController extends Controller
{
  public function index(Request $request)
  {
    $query = User::with([
      'identity',
      'validity',
      'registration.studentDetails',
      'registration.studentFamily',
      'registration.studyProgram'
    ]);

    $limit = $request->get('limit', 10);

    if ($limit === 'all') {
      $users = $query->get();
    } else {
      $users = $query->paginate((int) $limit);
    }

    return response()->json([
      'status'  => 'success',
      'message' => 'List Data PMB',
      'payload' => $users
    ], 200);
  }
}
