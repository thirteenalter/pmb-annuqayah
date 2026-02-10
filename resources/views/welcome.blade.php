<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('components.icon')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .gradient-text {
            background: linear-gradient(to right, #1e293b, #475569);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes blob {
            0% {
                transform: scale(1);
            }

            33% {
                transform: scale(1.1) translateY(-10px);
            }

            66% {
                transform: scale(0.9) translateY(10px);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</head>

<body class="antialiased bg-slate-50">
    <div class="min-h-screen relative flex items-center justify-center py-12 px-4 overflow-x-hidden">

        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div
                class="absolute -top-24 -left-24 w-72 h-72 md:w-96 md:h-96 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
            </div>
            <div
                class="absolute top-1/2 -right-24 w-72 h-72 md:w-96 md:h-96 bg-slate-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
            </div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10 w-full">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-12">

                <div class="flex-1 text-center lg:text-left">
                    <img class="w-32 md:w-48 lg:w-56 mb-8 mx-auto lg:mx-0 drop-shadow-sm transition-transform hover:scale-105 duration-300"
                        src="https://pmb.ua.ac.id/wp-content/uploads/2025/01/cropped-1.-Logo-Alternatif-Universitas-Annuqayah.png"
                        alt="Logo Universitas">

                    <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-slate-800 leading-tight mb-4">
                        Selamat Datang di <br>
                        <span class="gradient-text">{{ config('app.name', 'PMB Online') }}</span>
                    </h1>

                    <p
                        class="text-slate-500 text-base md:text-lg lg:text-xl max-w-2xl mx-auto lg:mx-0 leading-relaxed mb-8 px-2 md:px-0">
                        Sistem Informasi Penerimaan Mahasiswa Baru <span class="font-bold text-slate-700">Universitas
                            Annuqayah</span>.
                        Pendaftaran mudah, cepat, dan transparan.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start px-4 md:px-0">
                        @auth
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('pembuka') }}"
                                class="w-full sm:w-auto group relative bg-slate-900 text-white px-8 py-4 rounded-xl flex items-center justify-center gap-3 font-bold transition-all hover:bg-indigo-600 active:scale-95 shadow-lg">
                                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                                {{ auth()->user()->isAdmin() ? 'Panel Admin' : 'Dashboard' }}
                            </a>
                        @endauth

                        @guest
                            <a href="{{ route('register') }}"
                                class="w-full sm:w-auto group bg-slate-900 text-white px-8 py-4 rounded-xl flex items-center justify-center gap-3 font-bold transition-all hover:bg-indigo-600 active:scale-95 shadow-lg">
                                <span class="material-symbols-outlined text-[20px]">person_add</span>
                                Daftar Sekarang
                            </a>

                            <a href="{{ route('login') }}"
                                class="w-full sm:w-auto group bg-white text-slate-700 border border-slate-200 px-8 py-4 rounded-xl flex items-center justify-center gap-3 font-bold transition-all hover:border-slate-400 active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-[20px]">login</span>
                                Masuk Akun
                            </a>
                        @endguest
                    </div>

                    <div class="mt-12 flex items-center justify-center lg:justify-start gap-6 opacity-50 grayscale">
                        <p class="text-[10px] md:text-xs font-mono uppercase tracking-[0.2em] text-slate-500">
                            #PMBAnnuqayah2025
                        </p>
                    </div>
                </div>

                <div class="hidden lg:block flex-1 relative">
                    <div
                        class="relative w-full h-[500px] bg-white/40 backdrop-blur-md rounded-[2.5rem] border border-white/50 shadow-2xl overflow-hidden p-6">
                        <div class="flex flex-col h-full gap-4">
                            @php
                                use App\Models\Settings;
                                $settings = Settings::first();
                            @endphp
                            <div class="grid grid-cols-2 gap-4 h-3/4">
                                <div class="overflow-hidden rounded-[1.5rem] shadow-sm bg-slate-200">
                                    @if ($settings?->thumb1)
                                        <img class="w-full h-full object-cover transform hover:scale-110 transition duration-700"
                                            alt="Kampus"
                                            src="{{ route('image.settings', ['path' => $settings->thumb1]) }}">
                                    @endif
                                </div>
                                <div class="flex flex-col gap-4">
                                    <div class="h-1/2 overflow-hidden rounded-[1.5rem] shadow-sm bg-slate-200">
                                        @if ($settings?->thumb2)
                                            <img src="{{ route('image.settings', ['path' => $settings->thumb2]) }}"
                                                class="w-full h-full object-cover transform hover:scale-110 transition duration-700"
                                                alt="Kegiatan">
                                        @endif
                                    </div>
                                    <div
                                        class="h-1/2 bg-slate-100/50 rounded-[1.5rem] p-5 flex flex-col justify-center border border-white/50">
                                        <div class="w-10 h-1 bg-indigo-500 rounded-full mb-3"></div>
                                        <p class="text-slate-600 font-bold leading-tight uppercase text-xs">Integrity &
                                            Excellence</p>
                                        <p class="text-slate-400 text-[10px] mt-1">Universitas Annuqayah</p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="h-1/4 bg-indigo-600 rounded-[1.5rem] p-6 text-white flex items-center justify-between shadow-lg">
                                <div>
                                    <p class="font-bold text-base italic leading-none">"Masa depan dimulai di sini."</p>
                                    <p class="text-indigo-200 text-[10px] mt-2 font-medium tracking-widest uppercase">
                                        #PMB2026</p>
                                </div>
                                <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm">
                                    <span class="material-symbols-outlined text-sm">school</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
