<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'peran', // 'admin' atau 'user'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Nama kolom yang dipakai Laravel Auth untuk menampilkan nama depan.
     * Laravel default memakai kolom "name", di sini kita pakai "nama"
     * sehingga kita override accessor "name" agar tetap kompatibel
     * dengan komponen bawaan (misal Auth::user()->name).
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['nama'] ?? '';
    }

    /**
     * Kolom "name" bawaan Laravel (NOT NULL) tidak kita pakai secara aktif,
     * tapi tetap wajib diisi karena ada di skema tabel users bawaan.
     * Di sini kita isi otomatis dari kolom "nama" setiap kali data disimpan,
     * supaya tidak melanggar constraint NOT NULL pada kolom "name".
     */
    protected static function booted(): void
    {
        static::saving(function (User $user) {
            $user->attributes['name'] = $user->nama;
        });
    }

    public function isAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    /**
     * Relasi: satu pengguna dapat memiliki banyak reservasi.
     */
    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'user_id');
    }
}
