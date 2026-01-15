<x-app-layout>
    <x-subnavbaradmin />

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">

            {{-- Header --}}
            <div class="mb-8 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Monitoring Pembayaran</h2>
                    <p class="text-sm text-slate-500">Validasi bukti transfer pendaftaran mahasiswa baru.</p>
                </div>

                {{-- Form Filter & Pencarian Gabungan --}}
                <form action="{{ route('admin.pembayaran') }}" method="GET"
                    class="flex flex-col md:flex-row items-center gap-3">
                    {{-- Dropdown Filter Gelombang --}}
                    <select name="wave_id" onchange="this.form.submit()"
                        class="w-full md:w-48 pl-4 pr-10 py-2 bg-white border border-slate-200 rounded-2xl text-sm focus:ring-indigo-500 focus:border-indigo-500 font-bold text-slate-700">
                        <option value="">Semua Gelombang</option>
                        @foreach ($waves as $wave)
                            <option value="{{ $wave->id }}" {{ request('wave_id') == $wave->id ? 'selected' : '' }}>
                                {{ $wave->name }} {{ $wave->is_active ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Input Pencarian --}}
                    <div class="relative w-full md:w-64">
                        <span
                            class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm">search</span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama/email..."
                            class="pl-10 pr-4 py-2 w-full bg-white border border-slate-200 rounded-2xl text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <button type="submit"
                        class="w-full md:w-auto px-6 py-2 bg-slate-900 text-white rounded-2xl text-sm font-bold hover:bg-slate-800 transition-colors">
                        Filter
                    </button>

                    {{-- Tombol Reset jika ada filter --}}
                    @if (request('search') || request('wave_id'))
                        <a href="{{ route('admin.pembayaran') }}"
                            class="text-xs font-bold text-red-500 hover:underline">Reset</a>
                    @endif
                </form>
            </div>

            {{-- Info Gelombang --}}
            <div class="mb-6 flex justify-end">
                <div
                    class="px-4 py-2 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-2xl text-xs font-bold">
                    Gelombang Aktif: <span class="text-indigo-900">{{ $activeWave->name ?? 'Tidak Ada' }}</span>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3 font-bold text-sm">
                    <span class="material-symbols-outlined">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel Data --}}
            <div class="bg-white shadow-sm border border-slate-200 rounded-3xl overflow-hidden mb-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-900 text-slate-400 text-[10px] uppercase font-bold tracking-widest">
                            <tr>
                                <th class="px-6 py-5">Mahasiswa</th>
                                <th class="px-6 py-5">Nama Rekening</th>
                                <th class="px-6 py-5 text-center">Bukti</th>
                                <th class="px-6 py-5">Status</th>
                                <th class="px-6 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($allPayments as $payment)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800">{{ $payment->user->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $payment->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-700 font-medium">{{ $payment->account_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.dashboard.pendaftar.show', [$payment->user->id]) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 rounded-xl text-[10px] font-bold hover:bg-indigo-600 hover:text-white transition-all">
                                            <span class="material-symbols-outlined text-sm">image</span> LIHAT
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $status = $payment->user->validity->final_status ?? 'pending';
                                            $color = [
                                                'valid' => 'bg-green-100 text-green-700 border-green-200',
                                                'invalid' => 'bg-red-100 text-red-700 border-red-200',
                                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            ][$status];
                                        @endphp
                                        <span
                                            class="{{ $color }} px-3 py-1 border rounded-full text-[10px] font-black uppercase tracking-tighter">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            {{-- Gunakan admin.pembayaran.update dan kirim ID --}}
                                            @if ($status !== 'valid')
                                                {{-- Ganti dari admin.pembayaran ke admin.pembayaran.update --}}
                                                <form action="{{ route('admin.pembayaran.update', $payment->id) }}"
                                                    method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="valid">
                                                    <button type="submit" ...>
                                                        <span class="material-symbols-outlined text-sm">check</span>
                                                    </button>
                                                </form>
                                            @endif

                                            <button onclick="toggleModal('modal-{{ $payment->id }}')"
                                                class="w-8 h-8 flex items-center justify-center bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all">
                                                <span class="material-symbols-outlined text-sm">close</span>
                                            </button>
                                        </div>

                                        {{-- Modal Alasan Penolakan --}}
                                        <div id="modal-{{ $payment->id }}"
                                            class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                                            <div
                                                class="bg-white rounded-3xl p-8 max-w-sm w-full text-left shadow-2xl border border-slate-100">
                                                <h3 class="font-black text-slate-800 mb-2 text-xl">Tolak Pembayaran</h3>
                                                <form action="{{ route('admin.pembayaran.update', $payment->id) }}"
                                                    method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="invalid">
                                                    <textarea name="admin_note" required
                                                        class="w-full rounded-2xl border-slate-200 text-sm mb-6 focus:ring-red-500 focus:border-red-500" rows="3"
                                                        placeholder="Alasan penolakan..."></textarea>
                                                    <div class="flex gap-3">
                                                        <button type="button"
                                                            onclick="toggleModal('modal-{{ $payment->id }}')"
                                                            class="flex-1 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold text-sm text-center">Batal</button>
                                                        <button type="submit"
                                                            class="flex-1 py-3 bg-red-600 text-white rounded-2xl font-bold text-sm">Kirim</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <p class="text-slate-400 font-medium italic">Data tidak ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-4">
                {{ $allPayments->links() }}
            </div>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
