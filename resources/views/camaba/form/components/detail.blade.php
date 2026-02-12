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
            <select name="penerima_kps" {{ $isLocked ? 'disabled' : '' }}
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }}">
                <option value="Iya"
                    {{ old('penerima_kps', $user->registration->studentDetails->penerima_kps ?? '') == 'Iya' ? 'selected' : '' }}>
                    Iya</option>
                <option value="Tidak"
                    {{ old('penerima_kps', $user->registration->studentDetails->penerima_kps ?? '') == 'Tidak' ? 'selected' : '' }}>
                    Tidak</option>
            </select>
        </div>



        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Alat Transportasi</label>
            <input type="text" name="alat_transportasi"
                value="{{ old('alat_transportasi', $user->registration->studentDetails->alat_transportasi ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} placeholder="Masukkan alat transportasi"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }} @error('nisn') border-red-500 @enderror">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Provinsi</label>
            <select name="provinsi" id="provinsi_select" {{ $isLocked ? 'disabled' : '' }}
                class="w-full px-4 py-3 rounded-xl border-slate-200">
                <option value="">Pilih Provinsi</option>
                @foreach ($provinces as $prov)
                    <option value="{{ $prov->nm_wil }}" data-id="{{ $prov->id_wil }}"
                        {{ old('provinsi', $user->registration->studentDetails->provinsi ?? '') == $prov->nm_wil ? 'selected' : '' }}>
                        {{ $prov->nm_wil }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="province_id" id="province_id_helper"
                value="{{ old('province_id', $user->registration->studentDetails->province_id ?? '') }}">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Kabupaten/Kota</label>
            <select name="kabupaten_kota" id="kabupaten_select" {{ $isLocked ? 'disabled' : '' }}
                class="w-full px-4 py-3 rounded-xl border-slate-200">
                <option value="">Pilih Kabupaten/Kota</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->nm_wil }}" data-id="{{ $city->id_wil }}"
                        {{ old('kabupaten_kota', $user->registration->studentDetails->kabupaten_kota ?? '') == $city->nm_wil ? 'selected' : '' }}>
                        {{ $city->nm_wil }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="city_id" id="city_id_helper"
                value="{{ old('city_id', $user->registration->studentDetails->city_id ?? '') }}">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Kecamatan</label>
            <select name="kecamatan" id="kecamatan_select" {{ $isLocked ? 'disabled' : '' }}
                class="w-full px-4 py-3 rounded-xl border-slate-200">
                <option value="">Pilih Kecamatan</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->nm_wil }}" data-id="{{ $district->id_wil }}"
                        {{ old('kecamatan', $user->registration->studentDetails->kecamatan ?? '') == $district->nm_wil ? 'selected' : '' }}>
                        {{ $district->nm_wil }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="district_id" id="district_id_helper"
                value="{{ old('district_id', $user->registration->studentDetails->district_id ?? '') }}">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const provSelect = document.getElementById('provinsi_select');
        const kabSelect = document.getElementById('kabupaten_select');
        const kecSelect = document.getElementById('kecamatan_select');

        const provHelper = document.getElementById('province_id_helper');
        const kabHelper = document.getElementById('city_id_helper');
        const kecHelper = document.getElementById('district_id_helper');

        // Event saat Provinsi dipilih
        provSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const provinceId = selectedOption.getAttribute('data-id');

            provHelper.value = provinceId; // Simpan ID ke hidden input
            kabSelect.innerHTML = '<option value="">Loading...</option>';
            kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

            fetch(`/api/regions/${provinceId}`)
                .then(res => res.json())
                .then(data => {
                    kabSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                    data.forEach(city => {
                        kabSelect.innerHTML +=
                            `<option value="${city.nm_wil}" data-id="${city.id_wil}">${city.nm_wil}</option>`;
                    });
                });
        });

        // Event saat Kabupaten dipilih
        kabSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const cityId = selectedOption.getAttribute('data-id');

            kabHelper.value = cityId; // Simpan ID ke hidden input
            kecSelect.innerHTML = '<option value="">Loading...</option>';

            fetch(`/api/regions/${cityId}`)
                .then(res => res.json())
                .then(data => {
                    kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(dist => {
                        kecSelect.innerHTML +=
                            `<option value="${dist.nm_wil}" data-id="${dist.id_wil}">${dist.nm_wil}</option>`;
                    });
                });
        });

        // Event saat Kecamatan dipilih
        kecSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            kecHelper.value = selectedOption.getAttribute('data-id');
        });

        if (provHelper.value) {
            fetch(`/api/regions/${provHelper.value}`)
                .then(res => res.json())
                .then(data => {
                    kabSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';

                    data.forEach(city => {
                        kabSelect.innerHTML +=
                            `<option value="${city.nm_wil}" data-id="${city.id_wil}">
                        ${city.nm_wil}
                    </option>`;
                    });

                    // SELECT YANG SUDAH DISIMPAN
                    if (kabHelper.value) {
                        const opt = kabSelect.querySelector(`[data-id="${kabHelper.value}"]`);
                        if (opt) opt.selected = true;
                    }
                });
        }

        if (kabHelper.value) {
            fetch(`/api/regions/${kabHelper.value}`)
                .then(res => res.json())
                .then(data => {
                    kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

                    data.forEach(dist => {
                        kecSelect.innerHTML +=
                            `<option value="${dist.nm_wil}" data-id="${dist.id_wil}">
                        ${dist.nm_wil}
                    </option>`;
                    });

                    if (kecHelper.value) {
                        const opt = kecSelect.querySelector(`[data-id="${kecHelper.value}"]`);
                        if (opt) opt.selected = true;
                    }
                });
        }

        if (provHelper.value) {
            const opt = provSelect.querySelector(`[data-id="${provHelper.value}"]`);
            if (opt) opt.selected = true;
        }


    });
</script>
