<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-indigo-500">assignment</span>
            Detail Mahasiswa
        </h2>
    </div>
    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">


        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Kewarganegaraan</label>
            <select name="kewarganegaraan" {{ $isLocked ? 'disabled' : '' }}
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }}">
                <option value="Indonesia"
                    {{ old('kewarganegaraan', $user->registration->studentDetails->kewarganegaraan ?? '') == 'Indonesia' ? 'selected' : '' }}>
                    Indonesia</option>
                <option value="Asing"
                    {{ old('kewarganegaraan', $user->registration->studentDetails->kewarganegaraan ?? '') == 'Asing' ? 'selected' : '' }}>
                    Asing</option>
            </select>
            {{-- Jika isLocked, tambahkan hidden input karena field 'disabled' tidak terkirim saat submit --}}
            @if ($isLocked)
                <input type="hidden" name="kewarganegaraan"
                    value="{{ $user->registration->studentDetails->kewarganegaraan ?? 'Indonesia' }}">
            @endif
        </div>




        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">NIK (Sesuai KTP)</label>
            <input type="number" name="nik_identity"
                value="{{ old('nik_identity', $user->identity->nik ?? ($user->nik ?? '')) }}"
                {{ $isLocked ? 'readonly' : '' }}
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }}">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">NISN</label>
            <input type="text" name="nisn" {{-- Mengambil dari studentDetails sesuai migration kita sebelumnya --}}
                value="{{ old('nisn', $user->registration->studentDetails->nisn ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} {{-- NISN standar adalah 10 digit --}} maxlength="10"
                oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Masukkan 10 digit NISN"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">

            @error('nisn')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">NPWP</label>
            <input type="text" name="npwp" {{-- Mengambil dari studentDetails sesuai migration kita sebelumnya --}}
                value="{{ old('npwp', $user->registration->studentDetails->npwp ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} {{-- NPWP standar adalah 15 digit --}} maxlength="15"
                oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Masukkan 15 digit NPWP"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">


        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Jalan</label>
            <input type="text" name="jalan" {{-- Mengambil dari studentDetails sesuai migration kita sebelumnya --}}
                value="{{ old('jalan', $user->registration->studentDetails->jalan ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan alamat jalan"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Telepon</label>
            <input type="text" name="telephone" {{-- Mengambil dari studentDetails sesuai migration kita sebelumnya --}}
                value="{{ old('telephone', $user->registration->studentDetails->telepon ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan nomor telepon"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">
            <i class="text-green-600 text-sm">Gunakan Format : 081xxx</i>
        </div>

        <div class="flex gap-2">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Dusun</label>
                <input type="text" name="dusun" {{-- Mengambil dari studentDetails sesuai migration kita sebelumnya --}}
                    value="{{ old('dusun', $user->registration->studentDetails->dusun ?? '') }}"
                    {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan dusun"
                    class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">


            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">RT</label>
                <input type="text" name="rt" {{-- Mengambil dari studentDetails sesuai migration kita sebelumnya --}}
                    value="{{ old('rt', $user->registration->studentDetails->rt ?? '') }}"
                    {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan rt"
                    class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">


            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">RW</label>
                <input type="text" name="rw" {{-- Mengambil dari studentDetails sesuai migration kita sebelumnya --}}
                    value="{{ old('rw', $user->registration->studentDetails->rw ?? '') }}"
                    {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan rw"
                    class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">


            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">HP</label>
            <input type="text" name="hp" {{-- Mengambil dari studentDetails sesuai migration kita sebelumnya --}}
                value="{{ old('hp', $user->registration->studentDetails->hp ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan hp"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">
            <i class="text-green-600 text-sm">Gunakan Format : 081xxx</i>
        </div>


        <div class="flex gap-2">
            <div class="flex-1">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kelurahan</label>
                <input type="text" name="kelurahan" {{-- Mengambil dari studentDetails sesuai migration kita sebelumnya --}}
                    value="{{ old('kelurahan', $user->registration->studentDetails->kelurahan ?? '') }}"
                    {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan kelurahan"
                    class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kode pos</label>
                <input type="text" name="kode_pos" {{-- Mengambil dari studentDetails sesuai migration kita sebelumnya --}}
                    value="{{ old('kode_pos', $user->registration->studentDetails->kode_pos ?? '') }}"
                    {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan kode pos"
                    class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <input type="text" name="email" {{-- Mengambil dari studentDetails sesuai migration kita sebelumnya --}}
                value="{{ old('email', $user->registration->studentDetails->email ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan email"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Penerima KPS</label>
            <select name="kewarganegaraan" {{ $isLocked ? 'disabled' : '' }}
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }}">
                <option value="Iya"
                    {{ old('kewarganegaraan', $user->registration->studentDetails->penerima_kps ?? '') == 'Iya' ? 'selected' : '' }}>
                    Iya</option>
                <option value="Tidak"
                    {{ old('kewarganegaraan', $user->registration->studentDetails->penerima_kps ?? '') == 'Tidak' ? 'selected' : '' }}>
                    Tidak</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Kecamatan</label>
            <input type="text" name="kecamatan"
                value="{{ old('kecamatan', $user->registration->studentDetails->kecamatan ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan kecamatan"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Alat Transportasi</label>
            <input type="text" name="alat_transportasi"
                value="{{ old('alat_transportasi', $user->registration->studentDetails->alat_transportasi ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan alat transportasi"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Tinggal</label>
            <input type="text" name="jenis_tinggal"
                value="{{ old('jenis_tinggal', $user->registration->studentDetails->jenis_tinggal ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan jenis tinggal"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">
            <i class="text-green-600 text-sm">Contoh : panti asuhan, bersama orang tua</i>

        </div>

    </div>
</div>
