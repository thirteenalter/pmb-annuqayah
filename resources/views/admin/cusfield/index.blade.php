<x-app-layout>
    <x-subnavbaradmin />
    <div class="mx-auto max-w-7xl py-10 px-4">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-black text-slate-800 uppercase tracking-widest">Custom Input Builder</h1>
                <p class="text-sm text-slate-500">Tambahkan field tambahan diluar tabel default.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="bg-indigo-900 p-8 rounded-3xl shadow-xl text-slate-50 h-fit">
                <h3 class="font-bold mb-6 flex items-center gap-2 uppercase text-xs tracking-widest">
                    <span class="material-symbols-outlined">add_box</span> Buat Field Baru
                </h3>
                <form action="{{ route('admin.custom-fields.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-[10px] font-bold text-indigo-300 uppercase">Judul / Label Input</label>
                        <input type="text" name="label"
                            class="w-full bg-indigo-800 border-none rounded-xl text-sm mt-1 text-white"
                            placeholder="Contoh: Ukuran Baju">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-indigo-300 uppercase">Tipe Data</label>
                        <select name="type"
                            class="w-full bg-indigo-800 border-none rounded-xl text-sm mt-1 text-white">
                            <option value="text">Teks (Singkat)</option>
                            <option value="number">Angka</option>
                            <option value="textarea">Paragraf (Panjang)</option>
                            <option value="file">Upload File / Gambar</option>
                            <option value="date">Tanggal</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-indigo-300 uppercase">Muncul di Halaman?</label>
                        <select name="category"
                            class="w-full bg-indigo-800 border-none rounded-xl text-sm mt-1 text-white">
                            <option value="registration">Page Registrasi (Tabel registrations)</option>
                            <option value="document">Page Dokumen (Tabel documents)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-indigo-300 uppercase">Deskripsi Penjelasan</label>
                        <textarea name="description" class="w-full bg-indigo-800 border-none rounded-xl text-sm mt-1 text-white" rows="2"></textarea>
                    </div>
                    <button type="submit"
                        class="w-full py-3 bg-indigo-500 hover:bg-indigo-400 rounded-xl font-bold transition-all uppercase text-xs">Simpan
                        Field</button>
                </form>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <th class="p-6">Label & Deskripsi</th>
                                <th class="p-6">Lokasi / Tipe</th>
                                <th class="p-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($fields as $field)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-6">
                                        <div class="font-bold text-slate-700">{{ $field->label }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase">
                                            {{ $field->description ?? 'Tanpa deskripsi' }}</div>
                                    </td>
                                    <td class="p-6">
                                        <span
                                            class="px-2 py-1 rounded-md bg-slate-100 text-[10px] font-bold text-slate-600 uppercase">{{ $field->category }}</span>
                                        <span
                                            class="block text-xs text-slate-400 mt-1 italic">{{ $field->type }}</span>
                                    </td>
                                    <td class="p-6 text-right">
                                        <form action="{{ route('admin.custom-fields.destroy', $field->id) }}"
                                            method="POST">
                                            @csrf @method('DELETE')
                                            <button class="text-rose-500 hover:scale-110 transition-transform">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
