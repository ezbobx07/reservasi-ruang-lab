<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'kapasitas',
        'lokasi',
        'fasilitas',
        'foto',
    ];

    /**
     * Relasi: satu ruang dapat memiliki banyak reservasi.
     */
    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'ruang_id');
    }

    /**
     * Accessor URL foto (jika ada) untuk ditampilkan di view.
     */
    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
