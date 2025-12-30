<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\CustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomFieldController extends Controller
{
  public function index()
  {
    $fields = CustomField::orderBy('order')->get();
    return view('admin.cusfield.index', compact('fields'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'label' => 'required',
      'type' => 'required',
      'category' => 'required|in:registration,document' //
    ]);

    CustomField::create([
      'label' => $request->label,
      'name' => Str::slug($request->label, '_'),
      'type' => $request->type,
      'description' => $request->description,
      'category' => $request->category,
      'is_required' => $request->has('is_required'),
      'options' => $request->options ? json_encode(explode(',', $request->options)) : null,
    ]);

    return back()->with('success', 'Input field baru berhasil ditambahkan!');
  }

  public function destroy(CustomField $customField)
  {
    $customField->delete();
    return back()->with('success', 'Field berhasil dihapus.');
  }
}
