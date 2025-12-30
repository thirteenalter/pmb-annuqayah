<x-app-layout>
    <x-subnavbaradmin />
    <div class="mx-auto max-w-7xl py-10 px-4">
        <div class="mb-8">
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-widest">Gelombang Pendaftaran</h1>
            <p class="text-sm text-slate-500">Atur masa aktif dan biaya pendaftaran.</p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-600 text-sm font-bold flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Buka Gelombang Baru --}}
        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm mb-8">
            <h3 class="font-bold text-slate-800 mb-6 uppercase text-xs tracking-widest">Buka Gelombang Baru</h3>
            <form action="{{ route('admin.admission.periods.store') }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Nama Gelombang</label>
                    <input type="text" name="name" required
                        class="w-full border-slate-200 rounded-xl text-sm mt-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                        placeholder="Gelombang 1">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Biaya (Rp)</label>
                    <input type="number" name="price" required
                        class="w-full border-slate-200 rounded-xl text-sm mt-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                        placeholder="250000">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Mulai</label>
                    <input type="datetime-local" name="start_date" required
                        class="w-full border-slate-200 rounded-xl text-sm mt-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Berakhir</label>
                    <input type="datetime-local" name="end_date" required
                        class="w-full border-slate-200 rounded-xl text-sm mt-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </div>
                <div class="md:col-span-4 flex justify-end mt-2">
                    <button type="submit"
                        class="px-8 py-3 bg-indigo-600 text-slate-50 font-bold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 uppercase text-xs tracking-widest">
                        Aktifkan Gelombang
                    </button>
                </div>
            </form>
        </div>

        {{-- List Gelombang --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($periods as $period)
                <div x-data="{ openEdit: false }"
                    class="bg-white rounded-3xl border {{ $period->is_active ? 'border-emerald-200 ring-2 ring-emerald-50' : 'border-slate-200' }} p-6 shadow-sm flex flex-col justify-between relative">

                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span
                                    class="px-3 py-1 rounded-full text-[9px] font-black uppercase {{ $period->is_active ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $period->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <h4 class="text-xl font-black text-slate-800 mt-2">{{ $period->name }}</h4>
                            </div>
                            <div class="flex gap-2">
                                {{-- TOMBOL EDIT --}}
                                <button @click="openEdit = true"
                                    class="p-2 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all">
                                    <span class="material-symbols-outlined">edit_square</span>
                                </button>
                                <form action="{{ route('admin.admission.periods.toggle', $period->id) }}"
                                    method="POST">
                                    @csrf @method('PATCH')
                                    <button
                                        class="p-2 material-symbols-outlined text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                        {{ $period->is_active ? 'toggle_on' : 'toggle_off' }}
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="space-y-2 mb-6">
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-500 font-medium">Biaya Pendaftaran:</span>
                                <span class="font-bold text-slate-700">Rp {{ number_format($period->price) }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-500 font-medium">Periode Aktif:</span>
                                <span class="font-bold text-slate-700">
                                    {{ \Carbon\Carbon::parse($period->start_date)->format('d M') }} -
                                    {{ \Carbon\Carbon::parse($period->end_date)->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-4 pt-4 border-t border-slate-50">
                        <form action="{{ route('admin.admission.periods.destroy', $period->id) }}" method="POST"
                            class="w-full" onsubmit="return confirm('Hapus gelombang ini secara permanen?')">
                            @csrf @method('DELETE')
                            <button
                                class="w-full py-2.5 text-[10px] font-bold text-rose-500 border border-rose-100 rounded-xl hover:bg-rose-50 transition-all uppercase tracking-widest">
                                Hapus Permanen
                            </button>
                        </form>
                    </div>

                    {{-- MODAL EDIT (Menggunakan x-show agar lebih stabil) --}}
                    <div x-show="openEdit" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 z-[999] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4"
                        style="display: none;">

                        <div class="bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl" @click.away="openEdit = false">

                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-black text-slate-800 uppercase tracking-widest">Update Gelombang
                                </h3>
                                <button @click="openEdit = false" class="text-slate-400 hover:text-slate-600">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>

                            <form action="{{ route('admin.admission.periods.update', $period->id) }}" method="POST"
                                class="space-y-4 text-left">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Nama Gelombang</label>
                                    <input type="text" name="name" value="{{ $period->name }}" required
                                        class="w-full border-slate-200 rounded-xl text-sm mt-1 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Biaya (Rp)</label>
                                    <input type="number" name="price" value="{{ $period->price }}" required
                                        class="w-full border-slate-200 rounded-xl text-sm mt-1 focus:ring-indigo-500">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Mulai</label>
                                        <input type="datetime-local" name="start_date"
                                            value="{{ \Carbon\Carbon::parse($period->start_date)->format('Y-m-d\TH:i') }}"
                                            required
                                            class="w-full border-slate-200 rounded-xl text-sm mt-1 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Berakhir</label>
                                        <input type="datetime-local" name="end_date"
                                            value="{{ \Carbon\Carbon::parse($period->end_date)->format('Y-m-d\TH:i') }}"
                                            required
                                            class="w-full border-slate-200 rounded-xl text-sm mt-1 focus:ring-indigo-500">
                                    </div>
                                </div>

                                <div class="flex gap-3 mt-8">
                                    <button type="button" @click="openEdit = false"
                                        class="flex-1 py-3 text-sm font-bold text-slate-500 bg-slate-100 rounded-xl hover:bg-slate-200 uppercase transition-all">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="flex-1 py-3 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 uppercase shadow-lg shadow-indigo-100 transition-all">
                                        Update Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
