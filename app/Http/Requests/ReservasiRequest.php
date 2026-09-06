<?php

namespace App\Http\Requests;

use App\Models\Reservasi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ReservasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // pengguna login mana pun boleh mengajukan reservasi
    }

    public function rules(): array
    {
        return [
            'ruang_id' => ['required', 'exists:ruangs,id'],
            'tanggal' => ['required', 'date', 'after_or_equal:today'],
            'waktu_mulai' => ['required', 'date_format:H:i'],
            'waktu_selesai' => ['required', 'date_format:H:i', 'after:waktu_mulai'],
            'keperluan' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.after_or_equal' => 'Tanggal reservasi tidak boleh di masa lalu.',
            'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai.',
        ];
    }

    /**
     * Validasi tambahan: pastikan tidak ada jadwal yang bentrok
     * untuk ruang dan tanggal yang sama.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return; // jangan cek bentrok jika validasi dasar sudah gagal
            }

            $reservasiId = $this->route('reservasi')?->id;

            $bentrok = Reservasi::bentrok(
                $this->input('ruang_id'),
                $this->input('tanggal'),
                $this->input('waktu_mulai'),
                $this->input('waktu_selesai'),
                $reservasiId
            )->exists();

            if ($bentrok) {
                $validator->errors()->add(
                    'waktu_mulai',
                    'Jadwal bentrok dengan reservasi lain pada ruang dan waktu yang sama.'
                );
            }
        });
    }
}
