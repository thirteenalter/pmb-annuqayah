<x-app-layout>
    <x-subnavbaradmin />

    <div class="mx-auto max-w-7xl py-10 px-4 lg:px-0">
        @if (session('success'))
            <div
                class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-600 text-sm font-bold flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <div
            class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                    <span class="material-symbols-outlined" style="font-size: 32px;">settings_accessibility</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 leading-tight">Keputusan Akhir</h2>
                    <p class="text-xs text-slate-500 font-medium italic">Status saat ini:
                        <span
                            class="font-bold {{ $user->status == 'valid' ? 'text-emerald-600' : ($user->status == 'invalid' ? 'text-rose-600' : 'text-amber-600') }} uppercase">
                            {{ $user->status }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="flex gap-2 bg-slate-100 p-1.5 rounded-2xl">
                <form action="{{ route('admin.pendaftar.validate', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="final_status" value="valid">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-xs font-bold transition-all {{ $user->status == 'valid' ? 'bg-emerald-600 text-white shadow-lg' : 'text-slate-500 hover:bg-white' }}">
                        SETUJU SEMUA (VALID)
                    </button>
                </form>
                <form action="{{ route('admin.pendaftar.validate', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="final_status" value="invalid">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-xs font-bold transition-all {{ $user->status == 'invalid' ? 'bg-rose-600 text-white shadow-lg' : 'text-slate-500 hover:bg-white' }}">
                        TOLAK SEMUA (INVALID)
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="space-y-6">
                <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm text-center">
                    <div
                        class="h-28 w-28 rounded-2xl bg-slate-100 mx-auto mb-4 border-4 border-white shadow-lg overflow-hidden">
                        @if ($user->document && $user->document->photo_formal)
                            <img src="{{ asset('storage/' . $user->document->photo_formal) }}"
                                class="h-full w-full object-cover">
                        @else
                            <div
                                class="h-full w-full flex items-center justify-center text-slate-300 font-bold text-2xl uppercase">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 leading-tight">
                        {{ $user->identity?->full_name ?? $user->name }}</h3>
                    <p class="text-xs text-slate-400 font-medium">{{ $user->email }}</p>

                    <div class="mt-6 pt-6 border-t border-slate-50 space-y-3 text-left">
                        <div class="flex justify-between">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Identitas</span>
                            <span
                                class="text-[10px] font-black {{ $user->validity?->is_data_valid ? 'text-emerald-600' : 'text-rose-500' }}">
                                {{ $user->validity?->is_data_valid ? 'VALID' : 'PENDING/INVALID' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span
                                class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Berkas/Bayar</span>
                            <span
                                class="text-[10px] font-black {{ $user->validity?->is_payment_valid ? 'text-emerald-600' : 'text-rose-500' }}">
                                {{ $user->validity?->is_payment_valid ? 'VALID' : 'PENDING/INVALID' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl shadow-slate-200">
                    <h4
                        class="font-bold text-slate-400 uppercase text-[10px] tracking-widest mb-5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">rocket_launch</span> Jalur Masuk
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <span class="text-[10px] text-slate-500 uppercase font-bold block mb-1">Gelombang</span>
                            {{-- Ambil dari relasi registration jika user->registration_period_id kosong --}}
                            <span
                                class="text-sm font-bold">{{ $user->registrationPeriod?->name ?? ($user->registration?->registrationPeriod?->name ?? '-') }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-500 uppercase font-bold block mb-1">Prodi</span>
                            <span class="text-sm font-bold text-indigo-400">
                                {{-- Jika menggunakan relasi ke model StudyProgram --}}
                                {{ $user->registration?->studyProgram?->name ?? ($user->registration?->study_program ?? '-') }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-500 uppercase font-bold block mb-1">No. Peserta</span>
                            <span
                                class="text-sm font-mono font-bold">{{ $user->registration?->participant_number ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-500 uppercase font-bold block mb-1">Jalur</span>
                            <span
                                class="text-sm font-mono font-bold">{{ $user->registration?->entry_path ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h4 class="font-bold text-slate-900 uppercase text-[11px] tracking-widest">Data Identitas</h4>
                        <div class="flex gap-2">
                            <form action="{{ route('admin.pendaftar.validate', $user->id) }}" method="POST">
                                @csrf
                                <button name="set_data" value="valid"
                                    class="px-3 py-1.5 rounded-lg text-[9px] font-black transition-all {{ $user->validity?->is_data_valid ? 'bg-emerald-600 text-white' : 'bg-white text-emerald-600 border border-emerald-200' }}">VALID</button>
                            </form>
                            <form action="{{ route('admin.pendaftar.validate', $user->id) }}" method="POST">
                                @csrf
                                <button name="set_data" value="invalid"
                                    class="px-3 py-1.5 rounded-lg text-[9px] font-black transition-all {{ !$user->validity?->is_data_valid && $user->validity?->verified_at ? 'bg-rose-600 text-white' : 'bg-white text-rose-600 border border-rose-200' }}">TOLAK</button>
                            </form>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Nama Lengkap
                                (Ijazah)</label>
                            <p class="text-sm font-bold text-slate-800">{{ $user->identity?->full_name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Nama Lengkap
                                Ibu</label>
                            <p class="text-sm font-bold text-slate-800">{{ $user->nama_ibu ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">NIK</label>
                            <p class="text-sm font-bold text-slate-800 tracking-wider">
                                {{ $user->identity?->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Tempat, Tanggal
                                Lahir</label>
                            <p class="text-sm font-bold text-slate-800">{{ $user->identity?->birth_place ?? '-' }},
                                {{ $user->identity?->birth_date ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Jenis
                                Kelamin</label>
                            <p class="text-sm font-bold text-slate-800">
                                {{ $user->identity?->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h4 class="font-bold text-slate-900 uppercase text-[11px] tracking-widest">Riwayat Pendidikan
                        </h4>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Asal
                                Sekolah</label>
                            <p class="text-sm font-bold text-slate-800">
                                {{ $user->registration?->school_origin ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Tahun Lulus</label>
                            <p class="text-sm font-bold text-slate-800">
                                {{ $user->registration?->graduation_year ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h4 class="font-bold text-slate-900 uppercase text-[11px] tracking-widest">Berkas & Pembayaran
                        </h4>
                        <div class="flex gap-2">
                            <form action="{{ route('admin.pendaftar.validate', $user->id) }}" method="POST">
                                @csrf
                                <button name="set_payment" value="valid"
                                    class="px-3 py-1.5 rounded-lg text-[9px] font-black transition-all {{ $user->validity?->is_payment_valid ? 'bg-emerald-600 text-white' : 'bg-white text-emerald-600 border border-emerald-200' }}">VALID</button>
                            </form>
                            <form action="{{ route('admin.pendaftar.validate', $user->id) }}" method="POST">
                                @csrf
                                <button name="set_payment" value="invalid"
                                    class="px-3 py-1.5 rounded-lg text-[9px] font-black transition-all {{ !$user->validity?->is_payment_valid && $user->validity?->verified_at ? 'bg-rose-600 text-white' : 'bg-white text-rose-600 border border-rose-200' }}">TOLAK</button>
                            </form>
                        </div>
                    </div>

                    <div class="p-6">
                        <div
                            class="mb-6 p-4 bg-amber-50 rounded-xl border border-amber-100 flex justify-between items-center">
                            <div>
                                <p class="text-[10px] font-bold text-amber-600 uppercase">Nama Pengirim (Rekening)</p>
                                <p class="text-sm font-black text-amber-900">
                                    {{ $user->payment?->account_name ?? 'Belum Upload' }}</p>
                            </div>
                            @if ($user->payment?->proof_file)
                                <a href="{{ asset('storage/' . $user->payment->proof_file) }}" target="_blank"
                                    class="px-4 py-2 bg-amber-600 text-white rounded-lg text-xs font-bold shadow-md">LIHAT
                                    BUKTI BAYAR</a>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @php
                                $docs = [
                                    ['label' => 'KTP', 'file' => $user->document?->ktp_scan],
                                    ['label' => 'KK', 'file' => $user->document?->kk_scan],
                                    ['label' => 'Ijazah', 'file' => $user->document?->ijazah_scan],
                                    ['label' => 'Rapor', 'file' => $user->document?->report_scan],
                                ];
                            @endphp
                            @foreach ($docs as $doc)
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                                    <p class="text-[9px] font-bold text-slate-400 uppercase mb-2">{{ $doc['label'] }}
                                    </p>
                                    @if ($doc['file'])
                                        <a href="{{ asset('storage/' . $doc['file']) }}" target="_blank"
                                            class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 underline">Buka
                                            File</a>
                                    @else
                                        <span class="text-[10px] text-slate-300 italic">Kosong</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Custom Fields - Informasi Tambahan --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h4 class="font-bold text-slate-900 uppercase text-[11px] tracking-widest">Informasi Tambahan
                            (Custom)</h4>
                    </div>
                    <div class="p-6">
                        @php
                            $customFields = $user->customFieldValues->filter(function ($item) {
                                return $item->customField !== null && $item->customField->category == 'registration';
                            });
                        @endphp

                        @if ($customFields->count() > 0) {{-- Gunakan count() > 0 --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                                @foreach ($customFields as $value)
                                    <div>
                                        <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">
                                            {{ $value->customField->label }}
                                        </label>
                                        <p class="text-sm font-bold text-slate-800">{{ $value->value ?? '-' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-4 text-center">
                                <span class="material-symbols-outlined text-slate-300 mb-2">info</span>
                                <p class="text-xs text-slate-400 italic">Tidak ada data informasi tambahan
                                    (registration) untuk pendaftar ini.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h4 class="font-bold text-slate-900 uppercase text-[11px] tracking-widest">Dokumen Tambahan
                            (Custom)</h4>
                    </div>
                    <div class="p-6">
                        {{-- Tambahan untuk Custom Fields Kategori Document --}}
                        @php
                            $customDocs = $user->customFieldValues->filter(function ($item) {
                                return $item->customField !== null && $item->customField->category == 'document';
                            });
                        @endphp

                        @if ($customDocs->count() > 0)
                            <p class="text-[10px] font-bold text-slate-400 uppercase mb-4 tracking-widest">Dokumen
                                Tambahan (Custom)</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach ($customDocs as $cDoc)
                                    <div class="p-3 bg-indigo-50/50 rounded-xl border border-indigo-100 text-center">
                                        <p class="text-[9px] font-bold text-indigo-400 uppercase mb-2">
                                            {{ $cDoc->customField->label }}
                                        </p>

                                        @if ($cDoc->customField->type == 'file')
                                            @if ($cDoc->value)
                                                <a href="{{ asset('storage/' . $cDoc->value) }}" target="_blank"
                                                    class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 underline flex items-center justify-center gap-1">
                                                    <span class="material-symbols-outlined text-xs">description</span>
                                                    Lihat File
                                                </a>
                                            @else
                                                <span class="text-[10px] text-slate-300 italic">Belum
                                                    diunggah</span>
                                            @endif
                                        @else
                                            {{-- Jika tipenya bukan file (text/select/date) --}}
                                            <p class="text-xs font-bold text-slate-700">{{ $cDoc->value ?? '-' }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>


                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                    <h4 class="font-bold text-slate-900 uppercase text-[11px] tracking-widest mb-4">Catatan Perbaikan
                        (Feedback)</h4>
                    <form action="{{ route('admin.pendaftar.validate', $user->id) }}" method="POST">
                        @csrf
                        <textarea name="admin_note" rows="3"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm mb-4 focus:ring-indigo-500"
                            placeholder="Tuliskan alasan penolakan atau instruksi perbaikan pendaftar...">{{ $user->validity?->admin_note }}</textarea>
                        <button type="submit"
                            class="w-full py-3 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition-all uppercase tracking-widest shadow-lg">
                            Update Catatan & Feedback
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
