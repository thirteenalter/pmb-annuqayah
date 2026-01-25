{{-- resources/views/camaba/form/components/special_needs.blade.php --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
    {{-- Header --}}
    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-500">accessible</span>
            Informasi Kebutuhan Khusus
        </h2>
    </div>

    {{-- Content Grid --}}
    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Kebutuhan Khusus Mahasiswa --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Kebutuhan Khusus Mahasiswa</label>
            <select name="kebutuhan_khusus_mahasiswa" {{ $isLocked ? 'disabled' : '' }}
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }}">
                <option value="Tidak"
                    {{ old('kebutuhan_khusus_mahasiswa', $user->registration->studentDetails->kebutuhan_khusus_mahasiswa ?? '') == 'Tidak' ? 'selected' : '' }}>
                    Tidak Ada
                </option>
                <option value="Tuna Netra"
                    {{ old('kebutuhan_khusus_mahasiswa', $user->registration->studentDetails->kebutuhan_khusus_mahasiswa ?? '') == 'Tuna Netra' ? 'selected' : '' }}>
                    Tuna Netra
                </option>
                <option value="Tuna Rungu"
                    {{ old('kebutuhan_khusus_mahasiswa', $user->registration->studentDetails->kebutuhan_khusus_mahasiswa ?? '') == 'Tuna Rungu' ? 'selected' : '' }}>
                    Tuna Rungu
                </option>
                <option value="Tuna Daksa"
                    {{ old('kebutuhan_khusus_mahasiswa', $user->registration->studentDetails->kebutuhan_khusus_mahasiswa ?? '') == 'Tuna Daksa' ? 'selected' : '' }}>
                    Tuna Daksa
                </option>
                <option value="Lainnya"
                    {{ old('kebutuhan_khusus_mahasiswa', $user->registration->studentDetails->kebutuhan_khusus_mahasiswa ?? '') == 'Lainnya' ? 'selected' : '' }}>
                    Lainnya
                </option>
            </select>
            @if ($isLocked)
                <input type="hidden" name="kebutuhan_khusus_mahasiswa"
                    value="{{ $user->registration->studentDetails->kebutuhan_khusus_mahasiswa ?? 'Tidak' }}">
            @endif
        </div>

        {{-- Kebutuhan Khusus Ayah --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Kebutuhan Khusus Ayah</label>
            <input type="text" name="kebutuhan_khusus_ayah"
                value="{{ old('kebutuhan_khusus_ayah', $user->registration->studentFamily->kebutuhan_khusus_ayah ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} placeholder="Contoh: Tidak ada"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }}">
        </div>

        {{-- Kebutuhan Khusus Ibu --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Kebutuhan Khusus Ibu</label>
            <input type="text" name="kebutuhan_khusus_ibu"
                value="{{ old('kebutuhan_khusus_ibu', $user->registration->studentFamily->kebutuhan_khusus_ibu ?? '') }}"
                {{ $isLocked ? 'readonly' : '' }} placeholder="Contoh: Tidak ada"
                class="w-full px-4 py-3 rounded-xl border-slate-200 {{ $isLocked ? 'bg-slate-50 text-slate-500' : '' }}">
        </div>

    </div>
</div>
