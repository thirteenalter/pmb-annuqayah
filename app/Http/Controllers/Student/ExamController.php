<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    if ($user->registrationPeriod->price === 0 && $user->validity->is_document_valid && $user->validity->is_data_valid) {
      $exams = Exam::withExists(['sessions' => function ($query) use ($user) {
        $query->where('user_id', $user->id)->where('status', 'done');
      }])->latest()->get();

      return view('camaba.exams.index', compact('exams'));
    }

    if (!$user->validity || $user->validity->final_status !== 'valid') {
      return view('camaba.unverified', [
        'status' => $user->validity->final_status ?? "pending",
        'note' => $user->validity->admin_note ?? 'Data kamu sedang dalam antrian verifikasi.'
      ]);
    }

    $exams = Exam::withExists(['sessions' => function ($query) use ($user) {
      $query->where('user_id', $user->id)->where('status', 'done');
    }])->latest()->get();

    return view('camaba.exams.index', compact('exams'));
  }

  public function show(Exam $exam)
  {
    $user = Auth::user();

    if (!$user->validity || $user->validity->final_status !== 'valid') {
      abort(403, 'Akses ditolak! Status verifikasi kamu belum VALID.');
    }

    $exam->load('questions.options');
    return view('camaba.exams.show', compact('exam'));
  }


  public function store(Request $request, Exam $exam)
  {
    $correctAnswers = 0;
    $totalQuestions = $exam->questions->count();

    if ($request->has('answers')) {
      foreach ($request->answers as $questionId => $optionId) {
        $question = $exam->questions()->find($questionId);
        if ($question) {
          $correctOption = $question->options()->where('is_correct', true)->first();
          if ($correctOption && $correctOption->id == $optionId) {
            $correctAnswers++;
          }
        }
      }
    }

    $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

    ExamSession::create([
      'user_id' => Auth::id(),
      'exam_id' => $exam->id,
      'score'   => round($score),
      'status'  => 'done' // GANTI JADI 'done', jangan 'finished'!
    ]);

    return redirect()->route('exams.index')
      ->with('success', 'Ujian selesai, Bos! Skor lu: ' . round($score));
  }
}
