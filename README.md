# Sistem Reservasi Ruang Laboratorium

Aplikasi web untuk mengelola pemesanan ruang laboratorium kampus, dibangun dengan **Laravel 10**, **Bootstrap 5**, dan **SweetAlert2**. Dibuat untuk memenuhi Tugas Remedial Praktikum Pemrograman Web.

## Fitur Utama
- Autentikasi: registrasi, login, logout, dua peran (**Admin** & **User**).
- CRUD **Data Ruang** (kode, nama, kapasitas, lokasi, fasilitas, foto) — khusus Admin.
- CRUD **Data Reservasi** — User mengajukan, Admin menyetujui/menolak.
- Relasi database: User ↔ Reservasi ↔ Ruang.
- **Pencegahan bentrok jadwal**: satu ruang tidak bisa dipesan dua kali pada rentang waktu yang beririsan di tanggal yang sama.
- Validasi sisi server (Form Request) dan validasi dasar sisi klien (atribut HTML5 `required`, `min`, dsb).
- Pencarian/filter: ruang (nama/kode/lokasi), reservasi (nama ruang, tanggal, status).
- Unggah foto ruang (JPG/PNG, maksimal 2MB).
- Notifikasi sukses/gagal & konfirmasi hapus memakai SweetAlert2.
- Tampilan responsif (Bootstrap 5) — nyaman diakses dari laptop maupun ponsel.
- **Fitur tambahan**: Dashboard ringkasan jumlah ruang & reservasi berdasarkan status.

## Struktur Data Utama
| Entitas | Atribut | Relasi |
|---|---|---|
| `users` | nama, email, password, peran (admin/user) | 1 user → banyak reservasi |
| `ruangs` | kode(unik), nama, kapasitas, lokasi, fasilitas, foto | 1 ruang → banyak reservasi |
| `reservasis` | user_id, ruang_id, tanggal, waktu_mulai, waktu_selesai, keperluan, status | banyak → 1 user, banyak → 1 ruang |

## Cara Instalasi (di komputer yang sudah terpasang PHP & Composer)

1. **Buat skeleton Laravel baru**, lalu salin (overwrite) folder proyek ini ke dalamnya:
   ```bash
   composer create-project laravel/laravel reservasi-lab
   cd reservasi-lab
   ```
   Salin seluruh isi folder `app/`, `database/`, `resources/views/`, `routes/`, dan file `.env.example` dari paket tugas ini ke dalam folder `reservasi-lab` hasil `composer create-project` (timpa file yang sama seperti `routes/web.php`).

2. **Salin konfigurasi environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Siapkan database** (default memakai SQLite agar mudah, tanpa perlu instal MySQL):
   ```bash
   touch database/database.sqlite
   ```
   Atau jika ingin memakai MySQL, sesuaikan variabel `DB_*` di file `.env`, lalu buat database kosong bernama `reservasi_lab`.

4. **Daftarkan middleware "admin"** di `app/Http/Kernel.php` (Laravel 10) — tambahkan baris berikut di dalam array `$middlewareAliases`:
   ```php
   'admin' => \App\Http\Middleware\AdminMiddleware::class,
   ```

5. **Jalankan migrasi dan seeder**:
   ```bash
   php artisan migrate --seed
   ```

6. **Buat symbolic link storage** (agar foto ruang yang diunggah dapat diakses via browser):
   ```bash
   php artisan storage:link
   ```

7. **Jalankan server pengembangan**:
   ```bash
   php artisan serve
   ```
   Buka `http://localhost:8000` di browser.

### Akun Demo (dari seeder)
| Peran | Email | Password |
|---|---|---|
| Admin | admin@lab.test | password |
| User | budi@lab.test | password |

## Rencana Pengembangan Lanjutan (opsional, untuk nilai lebih)
- Export rekap reservasi ke PDF/Excel (bisa memakai package `barryvdh/laravel-dompdf` atau `maatwebsite/excel`).
- Tampilan kalender jadwal ruang (misalnya dengan FullCalendar.js).
- Notifikasi status reservasi real-time di dashboard user (badge/counter).

## Struktur Folder Penting
```
app/
  Http/
    Controllers/          -> DashboardController, RuangController, ReservasiController
    Controllers/Auth/      -> AuthController (login, register, logout)
    Middleware/            -> AdminMiddleware
    Requests/              -> RuangRequest, ReservasiRequest (validasi server)
  Models/                  -> User, Ruang, Reservasi
database/
  migrations/              -> struktur tabel users(+peran), ruangs, reservasis
  seeders/                 -> DatabaseSeeder (akun & data contoh)
resources/views/
  layouts/app.blade.php    -> layout utama (navbar, SweetAlert2, Bootstrap)
  auth/                    -> login, register
  ruang/                   -> index, create, edit, _form
  reservasi/               -> index, create
  dashboard/               -> index (ringkasan)
routes/web.php             -> seluruh routing aplikasi
```

## Catatan Integritas Akademik
Kode ini adalah kerangka kerja fungsional yang dapat langsung dijalankan mengikuti langkah instalasi di atas. Mahasiswa **wajib memahami setiap bagian kode** (routing, controller, model, relasi, validasi) karena akan diminta demonstrasi atau perubahan kecil sesuai ketentuan tugas. Disarankan untuk:
- Menjalankan aplikasi dan mencoba seluruh fitur terlebih dahulu.
- Menyesuaikan tampilan/tema sesuai kreativitas pribadi (diperbolehkan sesuai instruksi tugas).
- Menyiapkan data contoh tambahan melalui seeder agar demonstrasi lebih meyakinkan.
- Membuat repository GitHub pribadi, melakukan commit bertahap (bukan sekali unggah), dan menulis README.md project (dasar dari file ini).
