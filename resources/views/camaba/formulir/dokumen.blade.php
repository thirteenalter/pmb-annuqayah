<x-app-layout>
    <x-subnavbarmaba />

    <div class="min-h-screen bg-slate-50 py-10 px-4">
        <div class="max-w-7xl mx-auto">

            @if (session('success'))
                <div
                    class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl flex items-center gap-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8 flex gap-4 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
                <span class="material-symbols-outlined text-amber-600">cloud_upload</span>
                <p class="text-sm text-amber-800">
                    Gunakan file format <strong>PDF atau JPG/PNG</strong> dengan ukuran maksimal <strong>2MB</strong>.

                </p>
            </div>

            @if ($isLocked)
                {{-- Tampilan saat data SUDAH TERKUNCI --}}
                <div class="mb-8 flex gap-4 p-4 bg-indigo-50 border border-indigo-200 rounded-2xl">
                    <span class="material-symbols-outlined text-indigo-600">lock</span>
                    <div>
                        <p class="text-sm font-bold text-indigo-900">Data Terkunci & Tersimpan</p>
                        <p class="text-sm text-indigo-800">Dokumen Anda telah berhasil difinalisasi. Silakan lanjut ke
                            tahap berikutnya.</p>
                    </div>
                </div>
            @else
                <div class="mb-8 flex gap-4 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
                    <span class="material-symbols-outlined text-amber-600">info</span>
                    <p class="text-sm text-amber-800">
                        Pastikan data yang Anda masukkan sesuai
                    </p>
                </div>

                @php
                    $docs = $user->document;
                    // Cek apakah semua dokumen wajib sudah diunggah
                    $isComplete =
                        $docs?->photo_formal &&
                        $docs?->ktp_scan &&
                        $docs?->kk_scan &&
                        $docs?->ijazah_scan &&
                        $docs?->report_scan;
                @endphp

                @if ($isComplete)
                    <div
                        class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl flex items-center gap-2">
                        <span class="material-symbols-outlined">check_circle</span>
                        <span class="text-sm">
                            Data Dokumen telah dilengkapi, menunggu verifikasi admin.
                            <span class="font-bold">(Hubungi admin jika berkas belum diverifikasi dalam 7 hari).</span>
                        </span>
                    </div>
                @else
                    <div
                        class="mb-4 p-4 bg-amber-100 border border-amber-200 text-amber-700 rounded-2xl flex items-center gap-2">
                        <span class="material-symbols-outlined">warning</span>
                        <span class="text-sm">Dokumen pendaftaran Anda belum lengkap. Silakan unggah berkas yang
                            diperlukan.</span>
                    </div>
                @endif

            @endif


            <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                {{-- Section 1: Dokumen Pokok (PERTAHANKAN DEFAULT) --}}
                <div
                    class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden {{ $isLocked ? 'opacity-75' : '' }}">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-500">file_present</span>
                            Dokumen Pokok (Wajib)
                        </h2>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Pribadi Formal</label>
                            @if ($user->document?->photo_formal)
                                <a href="{{ route('documents.view', 'photo_formal') }}" target="_blank"
                                    class="text-xs text-indigo-600 mb-2 block font-bold italic underline">
                                    Lihat File yang Sudah Diunggah
                                </a>
                            @endif
                            <input type="file" name="photo_formal" {{ $isLocked ? 'disabled' : '' }}
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Scan KTP / Kartu
                                Identitas</label>
                            @if ($user->document?->ktp_scan)
                                <a href="{{ route('documents.view', 'ktp_scan') }}" target="_blank"
                                    class="text-xs text-indigo-600 mb-2 block font-bold italic underline">
                                    Lihat File yang Sudah Diunggah
                                </a>
                            @endif
                            <input type="file" name="ktp_scan" {{ $isLocked ? 'disabled' : '' }}
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Scan Kartu Keluarga
                                (KK)</label>
                            @if ($user->document?->kk_scan)
                                <a href="{{ route('documents.view', 'kk_scan') }}" target="_blank"
                                    class="text-xs text-indigo-600 mb-2 block font-bold italic underline">
                                    Lihat File yang Sudah Diunggah
                                </a>
                            @endif
                            <input type="file" name="kk_scan" {{ $isLocked ? 'disabled' : '' }}
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Ijazah Terakhir / SKL</label>
                            @if ($user->document?->ijazah_scan)
                                <a href="{{ route('documents.view', 'ijazah_scan') }}" target="_blank"
                                    class="text-xs text-indigo-600 mb-2 block font-bold italic underline">
                                    Lihat File yang Sudah Diunggah
                                </a>
                            @endif
                            <input type="file" name="ijazah_scan" {{ $isLocked ? 'disabled' : '' }}
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Scan Rapor (Semester 1 -
                                5)</label>
                            @if ($user->document?->report_scan)
                                <a href="{{ route('documents.view', 'report_scan') }}" target="_blank"
                                    class="text-xs text-indigo-600 mb-2 block font-bold italic underline">
                                    Lihat File yang Sudah Diunggah
                                </a>
                            @endif
                            <input type="file" name="report_scan" {{ $isLocked ? 'disabled' : '' }}
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
                        </div>
                    </div>
                </div>

                {{-- Section 2: Dokumen Tambahan & Custom Fields --}}
                <div
                    class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden {{ $isLocked ? 'opacity-75' : '' }}">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-500">military_tech</span>
                            Dokumen Tambahan & Pendukung
                        </h2>
                    </div>
                    <div class="p-8 space-y-8">
                        {{-- Input Default (Sertifikat) --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Sertifikat Prestasi / Piagam
                                Lomba (Opsional)</label>
                            @if ($user->document?->achievement_certificate)
                                <a href="{{ route('documents.view', 'achievement_certificate') }}" target="_blank"
                                    class="text-xs text-indigo-600 mb-2 block font-bold italic underline">
                                    Lihat File yang Sudah Diunggah
                                </a>
                            @endif
                            <input type="file" name="achievement_certificate" {{ $isLocked ? 'disabled' : '' }}
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">
                        </div>

                        {{-- GARIS PEMISAH JIKA ADA CUSTOM FIELDS --}}
                        @if (isset($customFields) && $customFields->count() > 0)
                            <hr class="border-slate-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                @foreach ($customFields as $field)
                                    @php
                                        // Ambil data file custom yang sudah pernah diunggah
                                        $existingCustomValue = $user->customFieldValues
                                            ->where('custom_field_id', $field->id)
                                            ->first()?->value;
                                    @endphp
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            {{ $field->label }}
                                            @if ($field->is_required)
                                                <span class="text-rose-500">*</span>
                                            @endif
                                        </label>

                                        @if ($existingCustomValue)
                                            <a href="{{ route('custom.view', $field->id) }}" target="_blank"
                                                class="text-xs text-indigo-600 mb-2 block font-bold italic underline flex items-center gap-1">
                                                Lihat
                                                File yang Sudah Diunggah
                                            </a>
                                        @endif

                                        <input type="file" name="custom_{{ $field->id }}"
                                            {{ $field->is_required && !$existingCustomValue ? 'required' : '' }}
                                            {{ $isLocked ? 'disabled' : '' }}
                                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 border border-slate-200 rounded-xl p-1">

                                        @if ($field->description)
                                            <p class="text-[10px] text-slate-400 mt-1 italic">{{ $field->description }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Section 3: Action Buttons --}}
                <div class="flex flex-col md:flex-row items-center justify-end gap-4 pb-20">
                    @if (!$isLocked)
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
