<img src="https://pmb.ua.ac.id/wp-content/uploads/2025/01/cropped-1.-Logo-Alternatif-Universitas-Annuqayah.png" alt="img" />

# PMB Universitas Annuqayah - Sistem Informasi Penerimaan Mahasiswa Baru

Sistem Informasi **Penerimaan Mahasiswa Baru (PMB)** Universitas Annuqayah adalah platform berbasis web yang dirancang untuk mendigitalisasi dan mempermudah proses pendaftaran calon mahasiswa. Dibangun menggunakan **Laravel 11** dan **Laravel Breeze**, sistem ini menawarkan antarmuka modern, responsif, dan keamanan yang terjamin.

## 🚀 Fitur Utama

* **Autentikasi Modern:** Menggunakan Laravel Breeze untuk sistem login, registrasi, dan verifikasi email yang aman.
* **Dashboard Calon Mahasiswa:** Panel khusus bagi pendaftar untuk memantau status seleksi dan melengkapi berkas.
* **Formulir Pendaftaran Dinamis:** Pengisian data pribadi, riwayat pendidikan, dan pemilihan program studi.
* **Upload Berkas:** Fitur unggah dokumen persyaratan (Ijazah, KK, Foto, dll) secara digital.
* **Panel Admin (Opsional/TBA):** Manajemen data pendaftar, verifikasi berkas, dan laporan statistik.
* **Responsive Design:** Tampilan optimal di berbagai perangkat (Mobile, Tablet, Desktop) menggunakan Tailwind CSS.

---

## 🛠️ Teknologi yang Digunakan

* **Framework:** [Laravel 11](https://laravel.com)
* **Starter Kit:** [Laravel Breeze](https://www.google.com/search?q=https://laravel.com/docs/11.x/starter-kits%23laravel-breeze) (Blade & Alpine.js)
* **CSS Framework:** [Tailwind CSS](https://tailwindcss.com)
* **Database:** MySQL / MariaDB
* **Icons:** Google Icon



## 📦 Alur Kerja Sistem (Workflow)

Berikut adalah gambaran singkat proses pendaftaran di aplikasi ini:

1. **Registrasi:** Calon mahasiswa membuat akun.
2. **Pengisian Data:** Melengkapi profil dan data akademik.
3. **Unggah Dokumen:** Mengunggah bukti fisik pendukung.
4. **Verifikasi:** Admin memeriksa kelengkapan data.
4. **CBT:** Test Ujian.
5. **Pengumuman:** Calon mahasiswa melihat status kelulusan di dashboard.

---

## 💻 Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

### 1. Clone Repositori

```bash
git clone https://github.com/ryznxx/pmb-annuqayah.git
cd pmb-annuqayah

```

### 2. Instalasi Dependency (PHP & JS)

```bash
composer install
npm install

```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda.

```bash
cp .env.example .env

```

### 4. Generate Application Key

```bash
php artisan key:generate

```

### 5. Migrasi Database & Seeding

```bash
php artisan migrate --seed

```

### 6. Menjalankan Aplikasi

Buka dua terminal dan jalankan perintah berikut:

**Terminal 1 (Laravel Server):**

```bash
php artisan serve

```

**Terminal 2 (Vite/Asset Compiler):**

```bash
npm run dev

```

Aplikasi sekarang dapat diakses melalui `http://localhost:8000`.

---

## 📂 Struktur Folder Penting

* `app/Http/Controllers`: Logika utama pendaftaran dan autentikasi.
* `resources/views`: Template antarmuka (Blade files).
* `routes/web.php`: Definisi rute aplikasi.
* `database/migrations`: Skema database untuk tabel mahasiswa, prodi, dan berkas.


---

## ⚖️ Hak Cipta dan Ketentuan Penggunaan

Copyright © 2024 Ridho Alfahresi. Semua Hak Dilindungi Undang-Undang.

Source code ini dipublikasikan **hanya sebagai portofolio**. Tidak diizinkan bagi siapa pun untuk menyalin, mendistribusikan, atau menggunakan kode ini untuk kepentingan komersial, pribadi, maupun instansi (termasuk Universitas Annuqayah) tanpa izin tertulis dan penyelesaian administrasi yang sah dari pemilik kode.

Pelanggaran terhadap ketentuan ini akan diproses sesuai hukum hak cipta yang berlaku.

Jika Anda memiliki pertanyaan, silakan hubungi pengembang melalui [GitHub Issues](https://github.com/ryznxx/pmb-annuqayah/issues).
