{{-- resources/views/camaba/form/components/parents.blade.php --}}
<div class="space-y-8"> {{-- Memberi jarak antar section utama --}}

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden transition-all ">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-500 flex items-center justify-center shadow-lg shadow-sky-100">
                    <span class="material-symbols-outlined text-gray-900">man</span>
                </div>
                Data Ayah Kandung
            </h2>
            <span
                class="text-xs font-medium text-slate-900 bg-slate-100 px-3 py-1 rounded-full uppercase tracking-widest">Informasi
                Ayah</span>
        </div>

        <div class="p-8 md:p-10"> {{-- Padding diperbesar dari p-8 ke p-10 --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3"> {{-- Gap diperbesar (x-10, y-8) --}}

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">NIK Ayah</label>
                    <input type="text" name="nik_ayah" maxlength="16"
                        value="{{ old('nik_ayah', $user->registration->studentFamily->nik_ayah ?? '') }}"
                        {{ $isLocked ? 'readonly' : '' }} oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        placeholder="16 digit NIK"
                        class="w-full px-5 py-3.5 rounded-2xl border-slate-200 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all {{ $isLocked ? 'bg-slate-50' : '' }}">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Nama Lengkap Ayah</label>
                    <input type="text" name="nama_ayah"
                        value="{{ old('nama_ayah', $user->registration->studentFamily->nama_ayah ?? '') }}"
                        {{ $isLocked ? 'readonly' : '' }} placeholder="Nama sesuai KTP"
                        class="w-full px-5 py-3.5 rounded-2xl border-slate-200 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all {{ $isLocked ? 'bg-slate-50' : '' }}">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Tanggal Lahir Ayah</label>
                    <input type="date" name="tgl_lahir_ayah"
                        value="{{ old('tgl_lahir_ayah', $user->registration->studentFamily->tgl_lahir_ayah ?? '') }}"
                        {{ $isLocked ? 'readonly' : '' }}
                        class="w-full px-5 py-3.5 rounded-2xl border-slate-200 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Pendidikan Ayah</label>
                    <select name="pendidikan_ayah" {{ $isLocked ? 'disabled' : '' }}
                        class="w-full px-5 py-3.5 rounded-2xl border-slate-200 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all">
                        <option value="">Pilih Pendidikan</option>
                        @foreach (['SD', 'SMP', 'SMA/Sederajat', 'D3', 'D4/S1', 'S2', 'S3'] as $pnd)
                            <option value="{{ $pnd }}"
                                {{ old('pendidikan_ayah', $user->registration->studentFamily->pendidikan_ayah ?? '') == $pnd ? 'selected' : '' }}>
                                {{ $pnd }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah"
                        value="{{ old('pekerjaan_ayah', $user->registration->studentFamily->pekerjaan_ayah ?? '') }}"
                        {{ $isLocked ? 'readonly' : '' }} placeholder="Contoh: Wiraswasta"
                        class="w-full px-5 py-3.5 rounded-2xl border-slate-200">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Penghasilan Ayah</label>
                    <select name="penghasilan_ayah" {{ $isLocked ? 'disabled' : '' }}
                        class="w-full px-5 py-3.5 rounded-2xl border-slate-200 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all">
                        <option value="">Pilih Penghasilan</option>
                        @foreach (['< 1 Juta', '1 - 2 Juta', '2 - 5 Juta', '> 5 Juta'] as $ph)
                            <option value="{{ $ph }}"
                                {{ old('penghasilan_ayah', $user->registration->studentFamily->penghasilan_ayah ?? '') == $ph ? 'selected' : '' }}>
                                {{ $ph }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden transition-all hover:shadow-md">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl bg-rose-500 flex items-center justify-center shadow-lg shadow-rose-100">
                    <span class="material-symbols-outlined text-white">woman</span>
                </div>
                Data Ibu Kandung
            </h2>
            <span
                class="text-xs font-medium text-slate-400 bg-slate-100 px-3 py-1 rounded-full uppercase tracking-widest">Informasi
                Ibu</span>
        </div>

        <div class="p-8 md:p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8 gap-3">

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">NIK Ibu</label>
                    <input type="text" name="nik_ibu" maxlength="16"
                        value="{{ old('nik_ibu', $user->registration->studentFamily->nik_ibu ?? '') }}"
                        {{ $isLocked ? 'readonly' : '' }} oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        class="w-full px-5 py-3.5 rounded-2xl border-slate-200 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Nama Lengkap Ibu</label>
                    <input type="text" name="nama_ibu"
                        value="{{ old('nama_ibu', $user->registration->studentFamily->nama_ibu ?? '') }}"
                        {{ $isLocked ? 'readonly' : '' }}
                        class="w-full px-5 py-3.5 rounded-2xl border-slate-200 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Tanggal Lahir Ibu</label>
                    <input type="date" name="tgl_lahir_ibu"
                        value="{{ old('tgl_lahir_ibu', $user->registration->studentFamily->tgl_lahir_ibu ?? '') }}"
                        {{ $isLocked ? 'readonly' : '' }} class="w-full px-5 py-3.5 rounded-2xl border-slate-200">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Pendidikan Ibu</label>
                    <select name="pendidikan_ibu" {{ $isLocked ? 'disabled' : '' }}
                        class="w-full px-5 py-3.5 rounded-2xl border-slate-200">
                        <option value="">Pilih Pendidikan</option>
                        @foreach (['SD', 'SMP', 'SMA/Sederajat', 'D3', 'D4/S1', 'S2', 'S3'] as $pnd)
                            <option value="{{ $pnd }}"
                                {{ old('pendidikan_ibu', $user->registration->studentFamily->pendidikan_ibu ?? '') == $pnd ? 'selected' : '' }}>
                                {{ $pnd }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu"
                        value="{{ old('pekerjaan_ibu', $user->registration->studentFamily->pekerjaan_ibu ?? '') }}"
                        {{ $isLocked ? 'readonly' : '' }} class="w-full px-5 py-3.5 rounded-2xl border-slate-200">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-3">Penghasilan Ibu</label>
                    <select name="penghasilan_ibu" {{ $isLocked ? 'disabled' : '' }}
                        class="w-full px-5 py-3.5 rounded-2xl border-slate-200">
                        <option value="">Pilih Penghasilan</option>
                        @foreach (['Tidak Bekerja', '< 1 Juta', '1 - 2 Juta', '2 - 5 Juta', '> 5 Juta'] as $ph)
                            <option value="{{ $ph }}"
                                {{ old('penghasilan_ibu', $user->registration->studentFamily->penghasilan_ibu ?? '') == $ph ? 'selected' : '' }}>
                                {{ $ph }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
    </div>
</div>
