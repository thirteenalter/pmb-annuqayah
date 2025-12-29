<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;

class ExamQuestionController extends Controller
{
  public function create(Exam $exam)
  {
    return view('admin.exams.questions.create', compact('exam'));
  }

  public function store(Request $request, Exam $exam)
  {
    $request->validate([
      'question_text' => 'required|string',
      'options' => 'required|array|min:2',
      'options.*.text' => 'required|string',
      'correct_option' => 'required',
    ]);

    $question = $exam->questions()->create([
      'question_text' => $request->question_text,
    ]);

    foreach ($request->options as $index => $optionData) {
      $question->options()->create([
        'option_text' => $optionData['text'],
        'is_correct' => $index == $request->correct_option,
      ]);
    }

    return redirect()->route('admin.exams.show', $exam->id)
      ->with('success', 'Soal berhasil ditambahin, Bos!');
  }

  // Method buat nampilin halaman edit
  public function edit(Exam $exam, ExamQuestion $question)
  {
    // Load options biar kaga kosong pas di view
    $question->load('options');
    return view('admin.exams.questions.edit', compact('exam', 'question'));
  }

  // Method buat eksekusi update data
  public function update(Request $request, Exam $exam, ExamQuestion $question)
  {
    $request->validate([
      'question_text' => 'required|string',
      'options' => 'required|array|min:2',
      'options.*.text' => 'required|string',
      'correct_option' => 'required',
    ]);

    // Update teks soalnya dulu
    $question->update([
      'question_text' => $request->question_text,
    ]);

    // Hapus opsi yang lama, terus taro yang baru biar kaga ribet logicnya
    $question->options()->delete();

    foreach ($request->options as $index => $optionData) {
      $question->options()->create([
        'option_text' => $optionData['text'],
        'is_correct' => $index == $request->correct_option,
      ]);
    }

    return redirect()->route('admin.exams.show', $exam->id)
      ->with('success', 'Soal berhasil diupdate, kaga usah makasih!');
  }

  public function destroy(Exam $exam, ExamQuestion $question)
  {
    // Hapus soal (Otomatis hapus opsi kalo lu set 'onDelete cascade' di migration)
    $question->delete();

    return redirect()->route('admin.exams.show', $exam->id)
      ->with('success', 'Soal berhasil dibuang ke tong sampah!');
  }
}
