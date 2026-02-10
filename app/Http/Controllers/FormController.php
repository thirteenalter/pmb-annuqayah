<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistrationPeriod;
use App\Models\CustomField; // Tambahkan ini
use App\Models\CustomFieldValue; // Tambahkan ini
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;
use App\Models\StudyProgram;
use Illuminate\Support\Str;
use App\Models\User;

class FormController extends Controller
{

  public function createIdentity()
  {
    $user = Auth::user()->load(['identity', 'registration', 'validity']);

    $isLocked = $user->validity && (
      $user->validity->is_data_valid == 1
    );

    $studyPrograms = StudyProgram::where('is_active', true)->get();
    $customFields = CustomField::where('category', 'registration')->orderBy('order')->get();

    return view('camaba.formulir.create', [
      'user' => $user,
      'customFields' => $customFields,
      'studyPrograms' => $studyPrograms,
      'isLocked' => $isLocked // Pastikan ini dikirim ke view
    ]);
  }

  // 2. Tampilan Upload Dokumen
  public function createDocuments()
  {
    $user = Auth::user()->load(['document', 'validity']);
    $isLocked = optional($user->validity)->is_document_valid === true;

    // dd($isLocked);

    $customFields = CustomField::where('category', 'document')->orderBy('order')->get();

    return view('camaba.formulir.dokumen', [
      'user' => $user,
      'isLocked' => $isLocked,
      'customFields' => $customFields
    ]);
  }

  public function index()
  {
    $user = auth()->user();

    $selectedPeriodId = $user->registration_period_id;

    $periods = RegistrationPeriod::where('is_active', true)->get();

    return view('camaba.formulir.index', compact('periods', 'selectedPeriodId'));
  }

  public function pilihGelombang(Request $request)
  {
    $validated = $request->validate([
      'registration_period_id' => 'required|exists:registration_periods,id',
    ]);

    $user = $request->user();
    $newPeriodId = $request->registration_period_id;
    $period = RegistrationPeriod::find($newPeriodId);

    if ($user->registration_period_id != $newPeriodId) {

      $user->update([
        'registration_period_id' => $newPeriodId
      ]);

      if ($period->price == 0) {
        $user->payment()->updateOrCreate(
          ['user_id' => $user->id],
          [
            'account_name' => '-',
            'proof_file'   => '-',
            'status'       => 'success'
          ]
        );
      } else {
        if ($user->payment) {
          $user->payment()->delete();
        }
        if ($user->validity) {
          $user->validity()->delete();
        }
      }
    }

    return redirect()->route('student.index')->with('success', 'Gelombang berhasil diperbarui dan status pembayaran telah direset.');
  }

  private function saveCustomFields(Request $request, $category)
  {
    // 1. Ambil field yang relevan
    $customFields = CustomField::where('category', $category)->get();
    $userId = Auth::id();

    // Whitelist MIME yang diizinkan untuk custom fields
    $allowedMime = [
      'image/jpeg',
      'image/png',
      'application/pdf',
      'application/msword', // .doc
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
    ];

    foreach ($customFields as $field) {
      $inputName = 'custom_' . $field->id;

      // Skip jika tidak ada input
      if (!$request->has($inputName) && !$request->hasFile($inputName)) {
        continue;
      }

      $value = null;

      // 2. Keamanan Tipe File (Private Storage & Real MIME Check)
      if ($field->type == 'file' && $request->hasFile($inputName)) {
        $file = $request->file($inputName);

        if ($file->isValid()) {
          // Check MIME asli (Anti-Polyglot)
          $realMime = $file->getMimeType();

          if (in_array($realMime, $allowedMime)) {
            // Hapus file lama dari disk LOCAL sebelum ganti baru
            $oldValue = CustomFieldValue::where('user_id', $userId)
              ->where('custom_field_id', $field->id)
              ->first();

            if ($oldValue && $oldValue->value) {
              Storage::disk('local')->delete($oldValue->value);
            }

            // SIMPAN DI STORAGE LOCAL (PRIVATE)
            // Menggunakan hashName bawaan agar nama file acak & aman
            $value = $file->store('documents', 'local');
          }
        }
      }
      // 3. Keamanan Tipe Teks (Sanitasi XSS)
      else {
        $rawValue = $request->input($inputName);

        // strip_tags menghapus <script>, <html>, dll. 
        // trim menghapus spasi kosong yang tidak perlu
        $value = is_string($rawValue) ? trim(strip_tags($rawValue)) : $rawValue;
      }

      // 4. Update atau Simpan ke Database
      if ($value !== null) {
        CustomFieldValue::updateOrCreate(
          ['user_id' => $userId, 'custom_field_id' => $field->id],
          ['value' => $value]
        );
      }
    }
  }

  public function viewCustomField(CustomField $field)
  {
    $user = Auth::user();

    abort_unless($field->type === 'file', 404);

    $value = CustomFieldValue::where('user_id', $user->id)
      ->where('custom_field_id', $field->id)
      ->first();

    if (!$value || !$value->value) {
      abort(404);
    }

    $path = $value->value;

    if (!Storage::disk('local')->exists($path)) {
      abort(404);
    }

    return response()->file(
      storage_path('app/' . $path),
      [
        'Content-Type' => $value->mime ?? 'application/octet-stream',
        'Content-Disposition' => 'inline'
      ]
    );
  }




  public function storeDocuments(Request $request)
  {
    $user = Auth::user();
    $document = $user->document;

    if ($document && $document->is_dokumen_valid) {
      return back()->with('error', 'Dokumen sudah dikunci.');
    }

    $request->validate([
      'photo_formal'            => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
      'ktp_scan'                => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
      'kk_scan'                 => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
      'ijazah_scan'             => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
      'report_scan'             => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
      'achievement_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
    ]);

    $docFiles = ['photo_formal', 'ktp_scan', 'kk_scan', 'ijazah_scan', 'report_scan', 'achievement_certificate'];
    $docData = [];

    // Tipe MIME yang diizinkan
    $allowedMime = ['image/jpeg', 'image/png', 'application/pdf'];

    foreach ($docFiles as $field) {
      if ($request->hasFile($field)) {
        $file = $request->file($field);

        // 2. Perbaikan Deprecated: Gunakan getClientMimeType() atau helper File Laravel
        // Laravel secara internal sudah menggunakan symfony/mime yang lebih akurat dari finfo manual
        $realMime = $file->getMimeType();

        if (!in_array($realMime, $allowedMime)) {
          return redirect()->back()->with('error', "Tipe file untuk $field tidak valid.");
        }

        // 3. Nama File Acak (Tetap pertahankan keamanan)
        // Gunakan hashName() untuk menghasilkan nama unik yang tetap aman
        $path = $file->store('documents', 'local');

        $docData[$field] = $path;
      }
    }

    try {
      DB::transaction(function () use ($user, $docData, $request) {
        $user->document()->updateOrCreate(
          ['user_id' => $user->id],
          $docData
        );

        $this->saveCustomFields($request, 'document');
      });

      return redirect()->route('formulir.pembayaran')->with('success', 'Dokumen berhasil diunggah!');
    } catch (\Exception $e) {
      // Hapus file jika transaksi database gagal agar tidak ada sampah di server
      foreach ($docData as $filePath) {
        Storage::disk('local')->delete($filePath);
      }
      return redirect()->back()->with('error', 'Gagal menyimpan data.');
    }
  }


  public function storeIdentity(Request $request)
  {
    $user = Auth::user();

    $request->validate([
      'full_name'   => 'required|string|max:255',
      // Validasi Unique: tabel 'identities', kolom 'nik', kecualikan ID user saat ini
      'nik_identity' => [
        'required',
        'digits:16'
      ],
      'birth_place' => 'required|string',
      'birth_date'  => 'required|date',
      'gender'      => 'required|in:L,P',
      'entry_path'      => 'required',
      // Jika nomor peserta juga harus unik (opsional)
      'participant_number' => [
        'nullable',
        'unique:registrations,participant_number,' . $user->id . ',user_id'
      ],
      'school_origin'   => 'required',
      'graduation_year' => 'required|numeric',
      'study_program'   => 'required',
    ], [
      // Pesan kustom agar user paham
      'nik_identity.unique' => 'NIK ini sudah terdaftar. Silakan hubungi admin jika ini adalah NIK Anda.',
      'participant_number.unique' => 'Nomor peserta ini sudah digunakan oleh pendaftar lain.',
      'nik_identity.digits' => 'NIK harus berjumlah 16 digit.',
    ]);

    DB::transaction(function () use ($request, $user) {
      $user->identity()->updateOrCreate(['user_id' => $user->id], [
        'full_name'   => $request->full_name,
        'nik'         => $request->nik_identity,
        'birth_place' => $request->birth_place,
        'birth_date'  => $request->birth_date,
        'gender'      => $request->gender,
      ]);

      $user->registration()->updateOrCreate(['user_id' => $user->id], [
        'entry_path'         => $request->entry_path,
        'participant_number' => $request->participant_number,
        'school_origin'      => $request->school_origin,
        'graduation_year'    => $request->graduation_year,
        'study_program_id'   => $request->study_program,
      ]);

      $this->saveCustomFields($request, 'registration');
    });

    return redirect()->route('isi-dokumen')->with('success', 'Data identitas berhasil disimpan!');
  }


  public function viewStoreDocument(string $type)
  {
    $user = Auth::user();
    $doc  = $user->document;

    if (!$doc || !isset($doc->$type)) {
      abort(404);
    }

    $path = $doc->$type;

    if (!Storage::disk('local')->exists($path)) {
      abort(404);
    }

    return response()->file(storage_path('app/private/' . $path));
  }

  public function viewCustomFile(string $fieldId)
  {
    $user = Auth::user();

    // Cari data di tabel CustomFieldValue berdasarkan user dan ID field-nya
    $customValue = CustomFieldValue::where('user_id', $user->id)
      ->where('custom_field_id', $fieldId)
      ->first();

    if (!$customValue || empty($customValue->value)) {
      abort(404, 'File tidak ditemukan.');
    }

    // Gunakan helper serveDocument agar konsisten
    return $this->serveDocument($customValue->value);
  }

  public function viewAdminDocument(User $user, string $type)
  {
    abort_unless(Auth::user()->isAdmin(), 403);

    $doc = $user->document;

    if (!$doc || empty($doc->$type)) {
      abort(404);
    }

    return $this->serveDocument($doc->$type, true);
  }

  public function viewAdminCustomFile(User $user, string $fieldId)
  {
    abort_unless(Auth::user()->isAdmin(), 403);

    $customValue = CustomFieldValue::where('user_id', $user->id)
      ->where('custom_field_id', $fieldId)
      ->first();

    if (!$customValue || empty($customValue->value)) {
      abort(404, 'File tidak ditemukan.');
    }

    return $this->serveDocument($customValue->value, true);
  }



  private function serveDocument(string $path, bool $isAdmin = false)
  {
    if (!Storage::disk('local')->exists($path)) {
      abort(404);
    }

    return response()->file(
      Storage::disk('local')->path($path)
    );
  }



  public function storePayment(Request $request)
  {
    $request->validate([
      'account_name' => 'required|string|max:255',
      'proof_file'   => 'required|image|max:2048',
    ]);

    $user = Auth::user();
    $activeWave = RegistrationPeriod::where('is_active', true)->first();

    if (!$activeWave) {
      return back()->with('error', 'Maaf, tidak ada gelombang aktif.');
    }

    DB::transaction(function () use ($request, $user, $activeWave) {
      $user->payment()->updateOrCreate(
        ['user_id' => $user->id],
        [
          'account_name' => $request->account_name,
          // SIMPAN KE DISK 'local' (Private)
          'proof_file'   => $request->file('proof_file')->store('document', 'local'),
          'status'       => 'pending',
        ]
      );

      $user->registration_period_id = $activeWave->id;
      $user->registration->update(['registration_period_id' => $activeWave->id]);
      $user->save();
    });

    return redirect()->route('formulir')->with('success', 'Konfirmasi pembayaran berhasil dikirim!');
  }

  public function viewPayment($userId)
  {
    if (!auth()->user()->isAdmin() && auth()->id() !== (int)$userId) {
      abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
    }

    $payment = Payment::where('user_id', $userId)->firstOrFail();

    if (!Storage::disk('local')->exists($payment->proof_file)) {
      abort(404, 'File tidak ditemukan.');
    }


    return response()->file(storage_path('app/private/' . $payment->proof_file));
  }
}
