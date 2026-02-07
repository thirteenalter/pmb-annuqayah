<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\RegistrationPeriod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentRegistrationTest extends TestCase
{
  use RefreshDatabase; // Mengosongkan DB test setiap kali pengujian dijalankan

  public function test_user_can_store_complete_registration_data()
  {
    // 1. Persiapan: Buat Periode Pendaftaran (karena ada Foreign Key di Users)
    $period = RegistrationPeriod::create([
      'name' => 'Periode 2026',
      'is_active' => true
    ]);

    // 2. Persiapan: Buat User dan Login
    $user = User::factory()->create([
      'registration_period_id' => $period->id,
    ]);
    $this->actingAs($user);

    // 3. Data Dummy sesuai dengan request->validate di Controller kamu
    $dummyData = [
      // Identity & Registration
      'full_name'    => 'Ahmad Syarifuddin',
      'nik_identity' => '1234567890123456', // 16 digit
      'birth_place'  => 'Surabaya',
      'birth_date'   => '2005-05-20',
      'gender'       => 'L',
      'entry_path'   => 'Reguler',
      'study_program' => 1,
      'study_program_second' => 2,
      'kabupaten_kota' => 'KOTA SURABAYA',
      'kewarganegaraan' => 'Indonesia',
      'nisn'            => '0051234567', // 10 digit
      'hp'              => '081234567890',
      'email'           => 'ahmad@example.com',
      'kelurahan'       => 'Gubeng',
      'kecamatan'       => 'Gubeng',

      // Detail Alamat & Tambahan
      'provinsi'          => 'JAWA TIMUR',
      'jalan'             => 'Jl. Dharmawangsa No. 10',
      'dusun'             => 'Dusun Krajan',
      'rt'                => '001',
      'rw'                => '002',
      'kode_pos'          => '60281',
      'telephone'         => '031555666',
      'penerima_kps'      => 'Tidak',
      'alat_transportasi' => 'Sepeda Motor',
      'jenis_tinggal'     => 'Bersama Orang Tua',

      // Student Profile
      'religion'      => 'Islam',
      'nama_pondok'   => 'Al-Hidayah',
      'alamat_pondok' => 'Jombang',

      // Data Orang Tua
      'nama_ayah'       => 'Suryono',
      'nik_ayah'        => '3515000000000001',
      'tgl_lahir_ayah'  => '1975-01-01',
      'pendidikan_ayah' => 'S1',
      'pekerjaan_ayah'  => 'PNS',
      'penghasilan_ayah' => '5.000.000',

      'nama_ibu'        => 'Siti Aminah',
      'nik_ibu'         => '3515000000000002',
      'tgl_lahir_ibu'   => '1980-02-02',
      'pendidikan_ibu'  => 'SMA',
      'pekerjaan_ibu'   => 'Ibu Rumah Tangga',
      'penghasilan_ibu' => '0',

      // Kebutuhan Khusus
      'kebutuhan_khusus_mahasiswa' => 'Tidak Ada',
      'kebutuhan_khusus_ayah'      => 'Tidak Ada',
      'kebutuhan_khusus_ibu'       => 'Tidak Ada',
    ];

    // 4. Eksekusi: Kirim POST request ke route store
    // Ganti 'student.store' dengan nama route kamu yang mengarah ke function store tersebut
    $response = $this->post(route('student.store'), $dummyData);

    // 5. Assertions (Pembuktian)

    // Cek apakah redirect ke halaman isi-dokumen
    $response->assertRedirect(route('isi-dokumen'));
    $response->assertSessionHas('success');

    // Cek apakah data tersimpan di tabel identities
    $this->assertDatabaseHas('identities', [
      'user_id'   => $user->id,
      'full_name' => 'Ahmad Syarifuddin',
      'nik'       => '1234567890123456'
    ]);

    // Cek apakah data tersimpan di tabel registrations
    $this->assertDatabaseHas('registrations', [
      'user_id'          => $user->id,
      'study_program_id' => 1,
      'nisn'             => '0051234567'
    ]);

    // Cek apakah data tersimpan di tabel student_details
    $this->assertDatabaseHas('student_details', [
      'kabupaten_kota' => 'KOTA SURABAYA',
      'hp'             => '081234567890',
      'provinsi'       => 'JAWA TIMUR'
    ]);

    // Cek apakah data orang tua tersimpan
    $this->assertDatabaseHas('student_families', [
      'nama_ayah' => 'Suryono',
      'nama_ibu'  => 'Siti Aminah'
    ]);
  }
}
