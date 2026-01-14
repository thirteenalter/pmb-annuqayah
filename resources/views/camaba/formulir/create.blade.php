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


            @if ($isLocked)
                {{-- Tampilan saat data SUDAH TERKUNCI --}}
                <div class="mb-8 flex gap-4 p-4 bg-indigo-50 border border-indigo-200 rounded-2xl">
                    <span class="material-symbols-outlined text-indigo-600">lock</span>
                    <div>
                        <p class="text-sm font-bold text-indigo-900">Data Terkunci & Tersimpan</p>
                        <p class="text-sm text-indigo-800">Identitas Anda telah berhasil difinalisasi. Silakan lanjut ke
                            tahap berikutnya.</p>
                    </div>
                </div>
            @else
                {{-- Tampilan saat data BELUM TERKUNCI --}}
                <div class="mb-8 flex gap-4 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
                    <span class="material-symbols-outlined text-amber-600">info</span>
                    <p class="text-sm text-amber-800">
                        Pastikan data yang Anda masukkan sesuai dengan <strong>KTP/KK</strong> dan
                        <strong>Ijazah</strong> terakhir.
                    </p>
                </div>

                {{-- Notifikasi khusus jika sudah isi tapi belum diverifikasi (is_data_valid masih 0) --}}
                @if ($user->identity?->birth_place && $user->identity?->nik)
                    <div
                        class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl flex items-center gap-2">
                        <span class="material-symbols-outlined">check_circle</span>
                        <span class="text-sm">Data identitas telah dilengkapi, menunggu verifikasi admin. (Hubungi admin
                            jika berkas belum diverifikasi dalam 7 hari).</span>
                    </div>
                @endif
            @endif

            {{-- Tambahkan Fallback Error Global --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl">
                    <div class="flex items-center gap-2 mb-2 font-bold text-rose-800">
                        <span class="material-symbols-outlined">error</span>
                        Terjadi Kesalahan!
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1 ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('form.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div
                    class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden {{ $isLocked ? 'ring-2 ring-indigo-100' : '' }}">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-500">person</span>
                            Identitas Pribadi
                        </h2>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap (Sesuai
                                Ijazah)</label>
                            <input type="text" name="full_name"
                                value="{{ old('full_name', $user->identity->full_name ?? ($user->name ?? '')) }}"
                                {{ $isLocked ? 'readonly' : '' }}
                                class="w-full px-4 py-3 rounded-xl border-slate-200 transition-all {{ $isLocked ? 'bg-slate-50 text-slate-500' : 'focus:border-indigo-500 focus:ring-indigo-500' }}">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">NIK (Sesuai KTP)</label>
                            <input type="number" name="nik_identity"
                                value="{{ old('nik_identity', $user->identity->nik ?? ($user->nik ?? '')) }}"
                                {{ $isLocked ? 'readonly' : '' }}
                                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }}">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir</label>
                            <input type="text" name="birth_place"
                                value="{{ old('birth_place', $user->identity->birth_place ?? '') }}"
                                {{ $isLocked ? 'readonly' : '' }}
                                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }}">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir</label>
                            <input type="date" name="birth_date"
                                value="{{ old('birth_date', $user->identity->birth_date ?? '') }}"
                                {{ $isLocked ? 'readonly' : '' }}
                                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50' : '' }}">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Ibu</label>
                            <input type="text" name="school_origin"
                                value="{{ old('school_origin', $user->nama_ibu ?? '') }}"
                                {{ $isLocked ? 'readonly' : '' }}
                                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50' : '' }}">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                            <select name="gender" {{ $isLocked ? 'disabled' : '' }}
                                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50' : '' }}">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L"
                                    {{ old('gender', $user->identity->gender ?? '') == 'L' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="P"
                                    {{ old('gender', $user->identity->gender ?? '') == 'P' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-500">school</span>
                            Jalur Masuk & Asal Sekolah
                        </h2>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jalur Pendaftaran</label>
                            <select name="entry_path" {{ $isLocked ? 'disabled' : '' }}
                                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50' : '' }}">
                                <option value="">Pilih Jalur Masuk</option>
                                <option value="SNBP"
                                    {{ old('entry_path', $user->registration->entry_path ?? '') == 'SNBP' ? 'selected' : '' }}>
                                    SNBP (Prestasi)</option>
                                <option value="SNBT"
                                    {{ old('entry_path', $user->registration->entry_path ?? '') == 'SNBT' ? 'selected' : '' }}>
                                    SNBT (Tes Tulis)</option>
                                <option value="MANDIRI"
                                    {{ old('entry_path', $user->registration->entry_path ?? '') == 'MANDIRI' ? 'selected' : '' }}>
                                    Mandiri</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Peserta (Jika
                                Ada)</label>
                            <input type="text" name="participant_number"
                                value="{{ old('participant_number', $user->registration->participant_number ?? '') }}"
                                {{ $isLocked ? 'readonly' : '' }}
                                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50' : '' }}">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Sekolah Asal
                                (SMA/SMK/MA)</label>
                            <input type="text" name="school_origin"
                                value="{{ old('school_origin', $user->registration->school_origin ?? '') }}"
                                {{ $isLocked ? 'readonly' : '' }}
                                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50' : '' }}">
                        </div>



                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Lulus</label>
                            <input type="number" name="graduation_year"
                                value="{{ old('graduation_year', $user->registration->graduation_year ?? '') }}"
                                {{ $isLocked ? 'readonly' : '' }}
                                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50' : '' }}">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pilihan Program Studi</label>
                            <select name="study_program" {{ $isLocked ? 'disabled' : '' }}
                                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50' : 'focus:border-indigo-500 focus:ring-indigo-500' }}">
                                <option value="">Pilih Jurusan</option>

                                @foreach ($studyPrograms as $program)
                                    <option value="{{ $program->id }}"
                                        {{ old('study_program', $user->registration->study_program_id ?? '') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }} ({{ $program->faculty }})
                                    </option>
                                @endforeach
                            </select>
                            @error('study_program')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>



                @if (isset($customFields) && $customFields->count() > 0)
                    <div
                        class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden {{ $isLocked ? 'ring-2 ring-indigo-100 opacity-80' : '' }}">
                        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <span class="material-symbols-outlined text-indigo-500">add_notes</span>
                                Informasi Tambahan
                            </h2>
                        </div>
                        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($customFields as $field)
                                @php
                                    // Ambil data yang sudah pernah diisi oleh user untuk field ini
                                    $existingValue = $user->customFieldValues
                                        ->where('custom_field_id', $field->id)
                                        ->first()?->value;
                                @endphp

                                <div class="{{ $field->type == 'textarea' ? 'md:col-span-2' : '' }}">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        {{ $field->label }}
                                        @if ($field->is_required)
                                            <span class="text-rose-500">*</span>
                                        @endif
                                    </label>

                                    @if ($field->type == 'text' || $field->type == 'number' || $field->type == 'date')
                                        <input type="{{ $field->type }}" name="custom_{{ $field->id }}"
                                            value="{{ old('custom_' . $field->id, $existingValue) }}"
                                            {{ $field->is_required ? 'required' : '' }}
                                            {{ $isLocked ? 'readonly' : '' }}
                                            class="w-full px-4 py-3 rounded-xl border-slate-200 transition-all {{ $isLocked ? 'bg-slate-50 text-slate-500' : 'focus:border-indigo-500 focus:ring-indigo-500' }}"
                                            placeholder="{{ $field->description }}">
                                    @elseif($field->type == 'textarea')
                                        <textarea name="custom_{{ $field->id }}" rows="3" {{ $field->is_required ? 'required' : '' }}
                                            {{ $isLocked ? 'readonly' : '' }}
                                            class="w-full px-4 py-3 rounded-xl border-slate-200 transition-all {{ $isLocked ? 'bg-slate-50 text-slate-500' : 'focus:border-indigo-500 focus:ring-indigo-500' }}"
                                            placeholder="{{ $field->description }}">{{ old('custom_' . $field->id, $existingValue) }}</textarea>
                                    @endif

                                    @if ($field->description && !$isLocked)
                                        <p class="mt-1 text-xs text-slate-400 italic">*{{ $field->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex flex-col md:flex-row items-center justify-end gap-4 pb-20">
                    @if (!$isLocked)
                        <button type="submit"
                            class="w-full md:w-auto px-10 py-3 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 shadow-lg shadow-slate-200 transition-all transform hover:-translate-y-1">
                            Simpan & Finalisasi
                        </button>
                    @else
                        <a href="{{ route('isi-dokumen') }}"
                            class="w-full md:w-auto px-10 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-1 text-center">
                            Lanjut Upload Dokumen
                            <span class="material-symbols-outlined align-middle ml-1">arrow_forward</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
