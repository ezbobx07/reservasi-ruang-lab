<?php

namespace App\Http\Controllers;

use App\Http\Requests\RuangRequest;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RuangController extends Controller
{
    /**
     * Menampilkan daftar ruang, bisa dicari berdasarkan nama/kode/lokasi.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('q');

        $ruangs = Ruang::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%")
                      ->orWhere('kode', 'like', "%{$keyword}%")
                      ->orWhere('lokasi', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('nama')
            ->paginate(9)
            ->withQueryString();

        return view('ruang.index', compact('ruangs', 'keyword'));
    }

    public function create()
    {
        return view('ruang.create');
    }

    public function store(RuangRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ruang', 'public');
        }

        Ruang::create($data);

        return redirect()->route('ruang.index')
            ->with('sukses', 'Data ruang berhasil ditambahkan.');
    }

    public function edit(Ruang $ruang)
    {
        return view('ruang.edit', compact('ruang'));
    }

    public function update(RuangRequest $request, Ruang $ruang)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            // Hapus foto lama agar tidak menumpuk file yatim
            if ($ruang->foto) {
                Storage::disk('public')->delete($ruang->foto);
            }
            $data['foto'] = $request->file('foto')->store('ruang', 'public');
        }

        $ruang->update($data);

        return redirect()->route('ruang.index')
            ->with('sukses', 'Data ruang berhasil diperbarui.');
    }

    public function destroy(Ruang $ruang)
    {
        // Cegah penghapusan jika masih memiliki reservasi yang menunggu/disetujui
        if ($ruang->reservasis()->where('status', '!=', 'ditolak')->exists()) {
            return back()->with('gagal', 'Ruang tidak dapat dihapus karena masih memiliki reservasi aktif.');
        }

        if ($ruang->foto) {
            Storage::disk('public')->delete($ruang->foto);
        }

        $ruang->delete();

        return redirect()->route('ruang.index')
            ->with('sukses', 'Data ruang berhasil dihapus.');
    }
}
