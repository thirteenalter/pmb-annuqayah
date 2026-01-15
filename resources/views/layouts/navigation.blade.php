<head>
    @include('components.icon')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<nav class="bg-white border-b border-slate-200 sticky top-0 z-40" x-data="{ sideStatus: false }">
    <div class="max-w-7xl mx-auto py-3 flex justify-between items-center lg:px-0 px-4">

        <div class="flex items-center gap-12">
            <a href="/">
                <img class="w-32 lg:w-40 object-contain"
                    src="https://pmb.ua.ac.id/wp-content/uploads/2025/01/cropped-1.-Logo-Alternatif-Universitas-Annuqayah.png"
                    alt="Logo Universitas">
            </a>

            <div class="hidden lg:flex items-center gap-6">
                <a href="/"
                    class="flex items-center gap-1 text-sm text-slate-600 font-semibold hover:text-indigo-600 transition">
                    <span class="material-symbols-outlined" style="font-size: 18px;">garage_door</span>
                    Beranda
                </a>
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-1 text-sm text-slate-600 font-semibold hover:text-indigo-600 transition">
                        <span class="material-symbols-outlined" style="font-size: 18px;">admin_panel_settings</span>
                        Dashboard
                        Admin</a>
                @else
                    <a href="{{ route('pembuka') }}"
                        class="flex items-center gap-1 text-sm text-slate-600 font-semibold hover:text-indigo-600 transition">
                        <span class="material-symbols-outlined" style="font-size: 18px;">door_front</span>
                        Pembuka
                    </a>
                    <a href="{{ route('formulir') }}"
                        class="flex items-center gap-1 text-sm text-slate-600 font-semibold hover:text-indigo-600 transition">
                        <span class="material-symbols-outlined" style="font-size: 18px;">order_approve</span>
                        Formulir
                    </a>
                @endif

                {{-- <a href="/settings"
                    class="flex items-center gap-1 text-sm text-slate-600 font-semibold hover:text-indigo-600 transition">
                    <span class="material-symbols-outlined" style="font-size: 18px;">settings</span>
                    Pengaturan
                </a> --}}
            </div>
        </div>

        <div class="flex items-center gap-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="hidden lg:flex items-center gap-2 bg-slate-900 text-sm text-white px-6 py-2 rounded-xl font-bold hover:bg-slate-800 shadow-lg shadow-slate-200 transition-all active:scale-95"
                    type="submit">
                    <span class="material-symbols-outlined" style="font-size: 18px;">logout</span>
                    Keluar
                </button>
            </form>

            <button @click="sideStatus = true"
                class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="sideStatus" x-cloak class="relative z-[100]">
            <div x-show="sideStatus" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sideStatus = false"
                class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

            <aside x-show="sideStatus" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="fixed inset-y-0 right-0 w-72 bg-white shadow-2xl p-6 overflow-y-auto">

                <div class="flex items-center justify-between mb-8">
                    <span class="font-bold text-slate-800">Menu Navigasi</span>
                    <button @click="sideStatus = false" class="p-1 rounded-full hover:bg-slate-100 transition">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <nav class="flex flex-col gap-4">
                    <a href="/"
                        class="flex items-center gap-3 p-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition">
                        <span class="material-symbols-outlined">home</span> Beranda
                    </a>

                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 p-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition">
                            <span class="material-symbols-outlined">dashboard</span> Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('pembuka') }}"
                            class="flex items-center gap-3 p-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition">
                            <span class="material-symbols-outlined">explore</span> Pembuka
                        </a>
                        <a href="{{ route('formulir') }}"
                            class="flex items-center gap-3 p-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition">
                            <span class="material-symbols-outlined">assignment</span> Formulir
                        </a>
                    @endif

                    <a href="/settings"
                        class="flex items-center gap-3 p-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition">
                        <span class="material-symbols-outlined">settings</span> Pengaturan
                    </a>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 bg-red-50 text-red-600 p-3 rounded-xl font-bold hover:bg-red-100 transition">
                                <span class="material-symbols-outlined">logout</span> Keluar
                            </button>
                        </form>
                    </div>
                </nav>
            </aside>
        </div>
    </template>
</nav>
