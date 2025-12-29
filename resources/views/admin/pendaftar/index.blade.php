<x-app-layout>
    <x-subnavbaradmin />

    <div class="mx-auto max-w-7xl py-10 px-4 lg:px-0">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div
                class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm transition-hover hover:shadow-md duration-300">
                <div class="flex items-center gap-4">
                    <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-2xl">
                        <span class="material-symbols-outlined text-3xl">groups</span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-bold">Total Pendaftar</p>
                        <h3 class="text-2xl font-black text-slate-900">{{ $users->total() }}</h3>
                    </div>
                </div>
            </div>
            <div
                class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm transition-hover hover:shadow-md duration-300">
                <div class="flex items-center gap-4">
                    <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-2xl">
                        <span class="material-symbols-outlined text-3xl">check_circle</span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-bold">Akun Approved</p>
                        <h3 class="text-2xl font-black text-slate-900">
                            {{ $users->where('status', 'valid')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div
                class="bg-white p-6 rounded-3xl border border-slate-200/60 shadow-sm transition-hover hover:shadow-md duration-300">
                <div class="flex items-center gap-4">
                    <div class="p-3.5 bg-amber-50 text-amber-600 rounded-2xl">
                        <span class="material-symbols-outlined text-3xl">pending</span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-bold">Menunggu Verifikasi</p>
                        <h3 class="text-2xl font-black text-slate-900">{{ $users->where('status', 'invalid')->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80  shadow-slate-200/40 overflow-hidden">

            <div class="p-6 border-b border-slate-100">
                <form action="{{ route('admin.dashboard.pendaftar') }}" method="GET"
                    class="flex flex-col md:flex-row gap-4">
                    <div class="relative flex-grow">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari Nama, Email, atau Asal Sekolah..."
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-sm">
                    </div>

                    <div class="flex gap-3">
                        <select name="wave_id" onchange="this.form.submit()"
                            class="bg-slate-50 border-transparent text-slate-600 text-sm rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 block w-full md:w-56 px-4 py-3 outline-none cursor-pointer">
                            <option value="">Semua Gelombang</option>
                            @foreach ($waves as $wave)
                                <option value="{{ $wave->id }}"
                                    {{ request('wave_id') == $wave->id ? 'selected' : '' }}>
                                    {{ $wave->name }}
                                </option>
                            @endforeach
                        </select>

                        @if (request('search') || request('wave_id'))
                            <a href="{{ route('admin.dashboard.pendaftar') }}"
                                class="flex items-center justify-center px-4 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-100 transition-colors">
                                <span class="material-symbols-outlined">restart_alt</span>
                            </a>
                        @endif

                        <button type="submit"
                            class="bg-indigo-600 text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 active:scale-95">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-xs uppercase tracking-widest font-black">
                            <th class="px-8 py-5">Pendaftar</th>
                            <th class="px-6 py-5">Identitas Peserta</th>
                            <th class="px-6 py-5">Asal Sekolah</th>
                            <th class="px-6 py-5">Gelombang</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-8 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($users as $user)
                            <tr class="group hover:bg-indigo-50/30 transition-all duration-200">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-12 w-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-100">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="font-bold text-slate-900 group-hover:text-indigo-700 transition-colors">{{ $user->name }}</span>
                                            <span class="text-xs text-slate-400 font-medium">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-bold text-slate-700">{{ $user->registration->participant_number ?? 'N/A' }}</span>
                                        <span
                                            class="text-[10px] px-2 py-0.5 rounded bg-slate-100 text-slate-500 w-fit mt-1">NIK:
                                            {{ $user->nik }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-sm font-medium text-slate-600">
                                    {{ $user->registration->school_origin ?? '-' }}
                                </td>
                                <td class="px-6 py-5">
                                    @if ($user->registrationPeriod)
                                        <div
                                            class="px-3 py-1.5 rounded-xl bg-white border border-slate-100 shadow-sm text-[11px] font-black text-indigo-600 w-fit uppercase">
                                            {{ $user->registrationPeriod->name }}
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-300 italic">Belum dipilih</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-100/50 text-amber-700 ring-amber-200',
                                            'approved' => 'bg-emerald-100/50 text-emerald-700 ring-emerald-200',
                                            'rejected' => 'bg-rose-100/50 text-rose-700 ring-rose-200',
                                        ];
                                    @endphp
                                    <span
                                        class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase ring-1 ring-inset {{ $statusClasses[$user->status] ?? 'bg-slate-100 text-slate-600 ring-slate-200' }}">
                                        {{ $user->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.dashboard.pendaftar.show', $user->id) }}"
                                            class="h-10 w-10 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 hover:border-indigo-200 hover:shadow-sm transition-all shadow-none"
                                            title="Detail Pendaftar">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </a>
                                        <button onclick="confirmDelete('{{ $user->id }}')"
                                            class="h-10 w-10 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-rose-600 hover:border-rose-200 hover:shadow-sm transition-all shadow-none">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="p-6 bg-slate-50 rounded-full mb-4">
                                            <span
                                                class="material-symbols-outlined text-slate-200 text-6xl">cloud_off</span>
                                        </div>
                                        <p class="text-slate-400 font-bold tracking-tight">Data Tidak Ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- <div class="p-8 border-t border-slate-50 bg-slate-50/30">
                {{ $users->links() }}
            </div> --}}
        </div>
    </div>
</x-app-layout>
