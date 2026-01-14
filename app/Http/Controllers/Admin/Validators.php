<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class Validators extends Controller
{
  //
  public function toggleDocumentValidity(User $user, Request $request)
  {
    $request->validate([
      'is_document_valid' => 'required|boolean',
    ]);

    $user->validity()->updateOrCreate(
      ['user_id' => $user->id],
      ['is_document_valid' => $request->boolean('is_document_valid')]
    );

    return back()->with('success', 'Status dokumen diperbarui.');
  }
}
