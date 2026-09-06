@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<h3 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h3>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card shadow-sm text-center border-0">
            <div class="card-body">
                <div class="text-muted small">Total Ruang</div>
                <div class="fs-2 fw-bold">{{ $totalRuang }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card shadow-sm text-center border-0 border-start border-4 border-warning">
            <div class="card-body">
                <div class="text-muted small">Menunggu</div>
                <div class="fs-2 fw-bold text-warning">{{ $ringkasan['menunggu'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card shadow-sm text-center border-0 border-start border-4 border-success">
            <div class="card-body">
                <div class="text-muted small">Disetujui</div>
                <div class="fs-2 fw-bold text-success">{{ $ringkasan['disetujui'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card shadow-sm text-center border-0 border-start border-4 border-danger">
            <div class="card-body">
                <div class="text-muted small">Ditolak</div>
                <div class="fs-2 fw-bold text-danger">{{ $ringkasan['ditolak'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-bold">
        <i class="bi bi-clock-history"></i> Reservasi Terbaru
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Ruang</th>
                    @if(auth()->user()->isAdmin())<th>Pengguna</th>@endif
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasiTerbaru as $r)
                <tr>
                    <td>{{ $r->ruang->nama }}</td>
                    @if(auth()->user()->isAdmin())<td>{{ $r->user->nama }}</td>@endif
                    <td>{{ $r->tanggal->format('d-m-Y') }}</td>
                    <td>{{ substr($r->waktu_mulai,0,5) }} - {{ substr($r->waktu_selesai,0,5) }}</td>
                    <td><span class="badge bg-{{ $r->statusBadgeClass() }}">{{ ucfirst($r->status) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Belum ada data reservasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
