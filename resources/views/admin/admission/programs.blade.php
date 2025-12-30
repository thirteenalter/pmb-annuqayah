<x-app-layout>
    <x-subnavbaradmin />
    <div class="mx-auto max-w-7xl py-10 px-4">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-widest">Pengaturan Program Studi</h1>
            <p class="text-sm text-slate-500">Tambahkan atau hapus jurusan yang tersedia.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-indigo-900 p-8 rounded-3xl shadow-xl text-slate-50">
                    <h3 class="font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined">add_circle</span>
                        Prodi Baru
                    </h3>
                    <form action="{{ route('admin.admission.programs.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="text-[10px] font-bold text-indigo-300 uppercase">Nama Program Studi</label>
                            <input type="text" name="name" required
                                class="w-full bg-indigo-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-400 text-white mt-1"
                                placeholder="Contoh: S1 Informatika">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-indigo-300 uppercase">Fakultas</label>
                            <input type="text" name="faculty"
                                class="w-full bg-indigo-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-400 text-white mt-1"
                                placeholder="Contoh: Teknik">
                        </div>
                        <button type="submit"
                            class="w-full py-3 bg-indigo-500 hover:bg-indigo-400 rounded-xl font-bold transition-all mt-4">Simpan
                            Prodi</button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <th class="p-6">Nama Program Studi</th>
                                <th class="p-6">Fakultas</th>
                                <th class="p-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($programs as $program)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-6 font-bold text-slate-700">{{ $program->name }}</td>
                                    <td class="p-6 text-sm text-slate-500">{{ $program->faculty ?? '-' }}</td>
                                    <td class="p-6 text-right">
                                        <form action="{{ route('admin.admission.programs.destroy', $program->id) }}"
                                            method="POST" onsubmit="return confirm('Hapus prodi ini?')">
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
