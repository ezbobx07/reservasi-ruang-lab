<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    // Konstanta status agar konsisten dipakai di seluruh aplikasi
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DISETUJUI = 'disetujui';
    const STATUS_DITOLAK = 'ditolak';

    protected $fillable = [
        'user_id',
        'ruang_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'keperluan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
    }

    /**
     * Scope untuk mencari reservasi yang jadwalnya bentrok
     * pada ruang & tanggal yang sama, dengan rentang waktu yang beririsan.
     * Reservasi yang berstatus "ditolak" tidak dianggap bentrok.
     */
    public function scopeBentrok($query, $ruangId, $tanggal, $waktuMulai, $waktuSelesai, $kecualiId = null)
    {
        return $query->where('ruang_id', $ruangId)
            ->where('tanggal', $tanggal)
            ->where('status', '!=', self::STATUS_DITOLAK)
            ->when($kecualiId, fn ($q) => $q->where('id', '!=', $kecualiId))
            ->where(function ($q) use ($waktuMulai, $waktuSelesai) {
                // Dua rentang waktu beririsan jika mulai_A < selesai_B DAN mulai_B < selesai_A
                $q->where('waktu_mulai', '<', $waktuSelesai)
                  ->where('waktu_selesai', '>', $waktuMulai);
            });
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_DISETUJUI => 'success',
            self::STATUS_DITOLAK => 'danger',
            default => 'warning',
        };
    }
}
