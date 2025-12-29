<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request; // JANGAN LUPA IMPORT INI, ANJING!
use App\Models\ExamSession;

class ExamController extends Controller
{
  // List semua ujian
  public function index()
  {
    $exams = Exam::latest()->get();
    return view('admin.exams.index', compact('exams'));
  }

  // Method buat nampilin form create (yang tadi lu bikin view-nya)
  public function create()
  {
    return view('admin.exams.create');
  }

  // INI DIA YANG KURANG! Method buat nyimpen data ujian baru
  public function store(Request $request)
  {
    // Validasi dulu biar kaga masuk sampah ke database
    $request->validate([
      'title' => 'required|string|max:255',
      'duration' => 'required|integer|min:1',
    ]);

    // Simpen ke database
    $exam = Exam::create([
      'title' => $request->title,
      'duration' => $request->duration,
    ]);

    // Kalo udah sukses, arahin ke halaman detail buat nambahin soal
    return redirect()->route('admin.exams.show', $exam->id)
      ->with('success', 'Paket ujian berhasil dibuat! Sekarang isi soalnya, jan males.');
  }

  // Lihat detail ujian & daftar soalnya
  public function show(Exam $exam)
  {
    $exam->load('questions.options');
    return view('admin.exams.show', compact('exam'));
  }

  public function monitoring()
  {
    $sessions = ExamSession::with(['user', 'exam'])
      ->latest()
      ->get();

    return view('admin.exams.monitoring', compact('sessions'));
  }
}
