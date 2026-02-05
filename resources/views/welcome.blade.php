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

        /* Memastikan animasi blob tetap bekerja jika belum didefinisikan di CSS */
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

<body class="antialiased overflow-hidden">
    <div class="bg-slate-50 min-h-screen relative flex items-center justify-center">

        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div
                class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
            </div>
            <div
                class="absolute top-1/2 -right-24 w-96 h-96 bg-slate-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">

                <div class="flex-1 text-center lg:text-left">
                    <img class="w-48 lg:w-56 mb-10 mx-auto lg:mx-0 drop-shadow-sm transition-transform hover:scale-105 duration-300"
                        src="https://pmb.ua.ac.id/wp-content/uploads/2025/01/cropped-1.-Logo-Alternatif-Universitas-Annuqayah.png"
                        alt="Logo Universitas">

                    <h1 class="text-4xl md:text-6xl font-extrabold text-slate-800 leading-[1.15] mb-6">
                        Selamat Datang di <br>
                        <span class="gradient-text">{{ config('app.name', 'PMB Online') }}</span>
                    </h1>

                    <p class="text-slate-500 text-lg md:text-xl max-w-2xl mx-auto lg:mx-0 leading-relaxed mb-10">
                        Sistem Informasi Penerimaan Mahasiswa Baru <span class="font-bold text-slate-700">Universitas
                            Annuqayah</span>.
                        Wujudkan mimpi akademik Anda melalui proses pendaftaran yang mudah, cepat, dan transparan.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @auth
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('pembuka') }}"
                                class="group relative bg-slate-900 text-white px-8 py-4 rounded-2xl flex items-center justify-center gap-3 font-bold text-base transition-all hover:bg-indigo-600 hover:shadow-2xl hover:shadow-indigo-200 active:scale-95">
                                <span
                                    class="material-symbols-outlined group-hover:rotate-12 transition-transform">dashboard</span>
                                {{ auth()->user()->isAdmin() ? 'Panel Dashboard Admin' : 'Masuk ke Dashboard' }}
                            </a>
                        @endauth

                        @guest
                            <a href="{{ route('register') }}"
                                class="group bg-slate-900 text-white px-10 py-4 rounded-2xl flex items-center justify-center gap-3 font-bold text-base transition-all hover:bg-indigo-600 hover:shadow-2xl hover:shadow-indigo-200 active:scale-95">
                                <span class="material-symbols-outlined text-[20px]">person_add</span>
                                Daftar Sekarang
                            </a>

                            <a href="{{ route('login') }}"
                                class="group bg-white text-slate-700 border border-slate-200 px-10 py-4 rounded-2xl flex items-center justify-center gap-3 font-bold text-base transition-all hover:border-slate-400 hover:bg-slate-50 active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-[20px]">login</span>
                                Masuk Akun
                            </a>
                        @endguest
                    </div>

                    <div
                        class="mt-16 flex items-center justify-center lg:justify-start gap-6 opacity-40 grayscale hover:grayscale-0 transition-all duration-500">
                        <p class="text-xs font-mono uppercase tracking-[0.2em] text-slate-500">Pendaftaran Bisa Melalui
                            Page Ini</p>
                    </div>
                </div>

                <div class="hidden lg:block flex-1 relative">
                    <div
                        class="relative w-full h-[550px] bg-white/40 backdrop-blur-md rounded-[3rem] border border-white/50 shadow-2xl overflow-hidden p-6">
                        <div class="flex flex-col h-full gap-4">
                            @php
                                use App\Models\Settings;
                                $settings = Settings::first();
                            @endphp
                            <div class="grid grid-cols-2 gap-4 h-3/4">
                                <div class="overflow-hidden rounded-[2rem] shadow-sm border border-white/50">
                                    @if ($settings?->thumb1)
                                        <img class="w-full h-full object-cover transform hover:scale-110 transition duration-700"
                                            alt="Kampus"
                                            src="{{ route('image.settings', ['filename' => $settings->thumb1]) }}">
                                    @endif
                                </div>

                                <div class="flex flex-col gap-4">
                                    <div class="h-1/2 overflow-hidden rounded-[2rem] shadow-sm border border-white/50">
                                        @if ($settings?->thumb2)
                                            <img src="{{ route('image.settings', ['filename' => $settings->thumb2]) }}"
                                                class="w-full h-full object-cover transform hover:scale-110 transition duration-700"
                                                alt="Kegiatan">
                                        @endif
                                    </div>
                                    <div
                                        class="h-1/2 bg-slate-100/50 rounded-[2rem] p-6 flex flex-col justify-center border border-white/50">
                                        <div class="w-10 h-1 bg-indigo-500 rounded-full mb-3"></div>
                                        <p
                                            class="text-slate-600 font-bold leading-tight uppercase tracking-tighter text-sm">
                                            Integrity & Excellence</p>
                                        <p class="text-slate-400 text-xs mt-1">Universitas Annuqayah</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="h-1/4 bg-indigo-600 rounded-[2rem] p-6 text-white flex items-center justify-between shadow-lg shadow-indigo-200/50">
                                <div>
                                    <p class="font-bold text-lg italic leading-none">"Masa depan dimulai di sini."</p>
                                    <p class="text-indigo-200 text-xs mt-2 font-medium tracking-widest uppercase">
                                        #PMBAnnuqayah2025</p>
                                </div>
                                <div class="bg-white/20 p-3 rounded-2xl backdrop-blur-sm">
                                    <span class="material-symbols-outlined">school</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl"></div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
