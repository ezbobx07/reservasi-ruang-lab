// Menampilkan ringkasan data untuk admin maupun user
<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Ruang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Fitur tambahan: ringkasan jumlah ruang dan reservasi berdasarkan status.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $totalRuang = Ruang::count();

        $baseQuery = Reservasi::query()
            ->when(! $user->isAdmin(), fn ($q) => $q->where('user_id', $user->id));

        $ringkasan = [
            'total' => (clone $baseQuery)->count(),
            'menunggu' => (clone $baseQuery)->where('status', 'menunggu')->count(),
            'disetujui' => (clone $baseQuery)->where('status', 'disetujui')->count(),
            'ditolak' => (clone $baseQuery)->where('status', 'ditolak')->count(),
        ];

        $reservasiTerbaru = (clone $baseQuery)
            ->with(['ruang', 'user'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('dashboard.index', compact('totalRuang', 'ringkasan', 'reservasiTerbaru'));
    }
}
