<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RuangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        // Saat update, id ruang yang sedang diedit tersedia di route parameter "ruang"
        $ruangId = $this->route('ruang')?->id;

        return [
            'kode' => ['required', 'string', 'max:20', Rule::unique('ruangs', 'kode')->ignore($ruangId)],
            'nama' => ['required', 'string', 'max:100'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'lokasi' => ['required', 'string', 'max:150'],
            'fasilitas' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // maksimal 2MB
        ];
    }

    public function messages(): array
    {
        return [
            'kode.unique' => 'Kode ruang sudah digunakan, gunakan kode lain.',
            'kapasitas.min' => 'Kapasitas harus berupa angka positif.',
            'foto.image' => 'Berkas yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format foto hanya boleh JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
