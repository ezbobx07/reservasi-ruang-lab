<?php

namespace Database\Seeders;

use App\Models\Reservasi;
use App\Models\Ruang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin
        $admin = User::create([
            'nama' => 'Administrator',
            'email' => 'admin@lab.test',
            'password' => Hash::make('password'),
            'peran' => 'admin',
        ]);

        // Akun pengguna biasa
        $user = User::create([
            'nama' => 'Budi Mahasiswa',
            'email' => 'budi@lab.test',
            'password' => Hash::make('password'),
            'peran' => 'user',
        ]);

        // Contoh data ruang
        $ruang1 = Ruang::create([
            'kode' => 'LAB-01',
            'nama' => 'Laboratorium Pemrograman 1',
            'kapasitas' => 30,
            'lokasi' => 'Gedung A Lantai 2',
            'fasilitas' => 'Proyektor, AC, 30 unit komputer',
        ]);

        $ruang2 = Ruang::create([
            'kode' => 'LAB-02',
            'nama' => 'Laboratorium Jaringan',
            'kapasitas' => 20,
            'lokasi' => 'Gedung A Lantai 3',
            'fasilitas' => 'Proyektor, Rak server mini, 20 unit komputer',
        ]);

        // Contoh data reservasi
        Reservasi::create([
            'user_id' => $user->id,
            'ruang_id' => $ruang1->id,
            'tanggal' => now()->addDays(2)->toDateString(),
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '10:00',
            'keperluan' => 'Praktikum Pemrograman Web',
            'status' => Reservasi::STATUS_MENUNGGU,
        ]);

        Reservasi::create([
            'user_id' => $user->id,
            'ruang_id' => $ruang2->id,
            'tanggal' => now()->addDays(3)->toDateString(),
            'waktu_mulai' => '13:00',
            'waktu_selesai' => '15:00',
            'keperluan' => 'Diskusi kelompok tugas akhir',
            'status' => Reservasi::STATUS_DISETUJUI,
        ]);
    }
}
