<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>403 | Access Forbidden</title>
  @include('components.icon')
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="antialiased bg-slate-50 flex items-center justify-center min-h-screen">
  <div class="max-w-xl px-6 py-12 text-center">
    <div class="flex justify-center mb-8">
      <div class="p-6 bg-red-100 rounded-full text-red-600 shadow-sm flex items-center justify-center">
        <span class="material-symbols-outlined">
          search_off
        </span>
      </div>
    </div>
    <h1
      class="text-9xl font-extrabold text-slate-200/40 absolute inset-0 flex items-center justify-center -z-10 select-none">
      404
    </h1>

    <div class="relative z-10">
      <h2 class="text-4xl font-bold text-slate-800 tracking-tight mb-4">
        Halaman Tidak Ditemukan
      </h2>
      <p class="text-slate-600 text-lg mb-8 leading-relaxed">
        Maaf, halaman yang kamu cari tidak ditemukan. <br class="hidden md:block">
        Silakan hubungi admin jika menurutmu ini adalah sebuah kesalahan.
      </p>

      <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="{{ url()->previous() }}"
          class="w-full sm:w-auto px-8 py-3 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition-all duration-200 shadow-sm">
          Kembali
        </a>
        <a href="/"
          class="w-full sm:w-auto px-8 py-3 bg-slate-900 text-white font-semibold rounded-xl hover:bg-slate-800 transition-all duration-200 shadow-lg shadow-slate-200">
          Ke Beranda
        </a>
      </div>
    </div>

    <footer class="mt-16 text-slate-400 text-sm italic">
      "Maaf ya, halaman ini tidak ditemukan."
    </footer>
  </div>
</body>

</html>