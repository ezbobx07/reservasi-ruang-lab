<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservasiRequest;
use App\Models\Reservasi;
use App\Models\Ruang;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Admin melihat semua reservasi, user hanya melihat miliknya sendiri.
     * Bisa difilter berdasarkan nama ruang, tanggal, atau status.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $reservasis = Reservasi::query()
            ->with(['ruang', 'user'])
            ->when(! $user->isAdmin(), fn ($q) => $q->where('user_id', $user->id))
            ->when($request->filled('ruang'), fn ($q) => $q->whereHas('ruang', function ($qq) use ($request) {
                $qq->where('nama', 'like', '%' . $request->input('ruang') . '%');
            }))
            ->when($request->filled('tanggal'), fn ($q) => $q->whereDate('tanggal', $request->input('tanggal')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->orderByDesc('tanggal')
            ->orderBy('waktu_mulai')
            ->paginate(10)
            ->withQueryString();

        return view('reservasi.index', [
            'reservasis' => $reservasis,
            'filters' => $request->only(['ruang', 'tanggal', 'status']),
        ]);
    }

    public function create()
    {
        $ruangs = Ruang::orderBy('nama')->get();

        return view('reservasi.create', compact('ruangs'));
    }

    public function store(ReservasiRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['status'] = Reservasi::STATUS_MENUNGGU;

        Reservasi::create($data);

        return redirect()->route('reservasi.index')
            ->with('sukses', 'Reservasi berhasil diajukan, menunggu persetujuan admin.');
    }

    /**
     * Hanya admin yang boleh mengubah status reservasi (disetujui/ditolak).
     */
    public function updateStatus(Request $request, Reservasi $reservasi)
    {
        abort_unless($request->user()->isAdmin(), 403);

        $data = $request->validate([
            'status' => ['required', 'in:menunggu,disetujui,ditolak'],
        ]);

        $reservasi->update($data);

        return back()->with('sukses', 'Status reservasi berhasil diperbarui.');
    }

    public function destroy(Request $request, Reservasi $reservasi)
    {
        $user = $request->user();

        // User hanya boleh membatalkan reservasi miliknya sendiri yang masih menunggu
        if (! $user->isAdmin()) {
            abort_unless($reservasi->user_id === $user->id, 403);
            abort_unless($reservasi->status === Reservasi::STATUS_MENUNGGU, 403, 'Reservasi yang sudah diproses tidak dapat dibatalkan.');
        }

        $reservasi->delete();

        return back()->with('sukses', 'Reservasi berhasil dihapus.');
    }
}
