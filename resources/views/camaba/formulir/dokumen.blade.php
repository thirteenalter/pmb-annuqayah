<x-app-layout>


  <x-subnavbarmaba />


@php
    $user = $user ?? auth()->user();
    $isLocked = ($user->document) ? true : false;
@endphp

  <div class="min-h-screen bg-slate-50 py-10 px-4">
    <div class="max-w-7xl mx-auto">

      @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
      @endif

      <div class="mb-8 flex gap-4 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
        <span class="material-symbols-outlined text-amber-600">cloud_upload</span>
        <p class="text-sm text-amber-800">
          Gunakan file format <strong>PDF atau JPG/PNG</strong> dengan ukuran maksimal <strong>2MB</strong>.
          @if($isLocked) <br><strong class="text-indigo-700 underline">Dokumen telah dikunci. Silakan hubungi admin jika ingin mengubah.</strong> @endif
        </p>
      </div>

      <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden {{ $isLocked ? 'opacity-75' : '' }}">
          <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
              <span class="material-symbols-outlined text-indigo-500">file_present</span>
              Dokumen Pokok (Wajib)
            </h2>
          </div>
          <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Pribadi Formal</label>
              @if($user->document?->photo_formal)
                <a href="{{ asset('storage/' . $user->document->photo_formal) }}" target="_blank" class="text-xs text-indigo-600 mb-2 block font-bold italic underline">Lihat File yang Sudah Diunggah</a>
              @endif
              <input type="file" name="photo_formal" {{ $isLocked ? 'disabled' : '' }}
                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Scan KTP / Kartu Identitas</label>
              @if($user->document?->ktp_scan)
                <a href="{{ asset('storage/' . $user->document->ktp_scan) }}" target="_blank" class="text-xs text-indigo-600 mb-2 block font-bold italic underline">Lihat File yang Sudah Diunggah</a>
              @endif
              <input type="file" name="ktp_scan" {{ $isLocked ? 'disabled' : '' }}
                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Scan Kartu Keluarga (KK)</label>
              @if($user->document?->kk_scan)
                <a href="{{ asset('storage/' . $user->document->kk_scan) }}" target="_blank" class="text-xs text-indigo-600 mb-2 block font-bold italic underline">Lihat File yang Sudah Diunggah</a>
              @endif
              <input type="file" name="kk_scan" {{ $isLocked ? 'disabled' : '' }}
                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Ijazah Terakhir / SKL</label>
              @if($user->document?->ijazah_scan)
                <a href="{{ asset('storage/' . $user->document->ijazah_scan) }}" target="_blank" class="text-xs text-indigo-600 mb-2 block font-bold italic underline">Lihat File yang Sudah Diunggah</a>
              @endif
              <input type="file" name="ijazah_scan" {{ $isLocked ? 'disabled' : '' }}
                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-slate-700 mb-2">Scan Rapor (Semester 1 - 5)</label>
              @if($user->document?->report_scan)
                <a href="{{ asset('storage/' . $user->document->report_scan) }}" target="_blank" class="text-xs text-indigo-600 mb-2 block font-bold italic underline">Lihat File yang Sudah Diunggah</a>
              @endif
              <input type="file" name="report_scan" {{ $isLocked ? 'disabled' : '' }}
                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
            </div>
          </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
              <span class="material-symbols-outlined text-indigo-500">military_tech</span>
              Dokumen Tambahan (Opsional)
            </h2>
          </div>
          <div class="p-8 space-y-6">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Sertifikat Prestasi / Piagam Lomba</label>
              @if($user->document?->achievement_certificate)
                <a href="{{ asset('storage/' . $user->document->achievement_certificate) }}" target="_blank" class="text-xs text-indigo-600 mb-2 block font-bold italic underline text-italic">Lihat File yang Sudah Diunggah</a>
              @endif
              <input type="file" name="achievement_certificate" {{ $isLocked ? 'disabled' : '' }}
                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
            </div>
          </div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-end gap-4 pb-20">
          @if(!$isLocked)
            <button type="submit"
              class="w-full md:w-auto px-10 py-3 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 shadow-lg transition-all transform hover:-translate-y-1">
              Unggah & Finalisasi
            </button>
          @else
            <a href="{{ route('formulir.pembayaran') }}"
              class="w-full md:w-auto px-10 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 shadow-lg transition-all transform hover:-translate-y-1 text-center">
              Lanjut ke Pembayaran
            </a>
          @endif
        </div>
      </form>
    </div>
  </div>
</x-app-layout>