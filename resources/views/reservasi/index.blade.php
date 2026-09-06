@extends('layouts.app')
@section('title', 'Reservasi')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h3 class="mb-0"><i class="bi bi-calendar-check"></i> Reservasi Ruang</h3>
    <a href="{{ route('reservasi.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Ajukan Reservasi
    </a>
</div>

<form method="GET" action="{{ route('reservasi.index') }}" class="row g-2 mb-4">
    <div class="col-6 col-md-3">
        <input type="text" name="ruang" class="form-control" placeholder="Nama ruang..." value="{{ $filters['ruang'] ?? '' }}">
    </div>
    <div class="col-6 col-md-3">
        <input type="date" name="tanggal" class="form-control" value="{{ $filters['tanggal'] ?? '' }}">
    </div>
    <div class="col-6 col-md-3">
        <select name="status" class="form-select">
            <option value="">-- Semua Status --</option>
            <option value="menunggu" @selected(($filters['status'] ?? '') === 'menunggu')>Menunggu</option>
            <option value="disetujui" @selected(($filters['status'] ?? '') === 'disetujui')>Disetujui</option>
            <option value="ditolak" @selected(($filters['status'] ?? '') === 'ditolak')>Ditolak</option>
        </select>
    </div>
    <div class="col-6 col-md-3">
        <button type="submit" class="btn btn-outline-secondary w-100"><i class="bi bi-funnel"></i> Filter</button>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Ruang</th>
                    @if(auth()->user()->isAdmin())<th>Pengguna</th>@endif
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Keperluan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasis as $r)
                <tr>
                    <td>{{ $r->ruang->nama }}</td>
                    @if(auth()->user()->isAdmin())<td>{{ $r->user->nama }}</td>@endif
                    <td>{{ $r->tanggal->format('d-m-Y') }}</td>
                    <td>{{ substr($r->waktu_mulai,0,5) }} - {{ substr($r->waktu_selesai,0,5) }}</td>
                    <td>{{ $r->keperluan }}</td>
                    <td><span class="badge bg-{{ $r->statusBadgeClass() }}">{{ ucfirst($r->status) }}</span></td>
                    <td>
                        @if(auth()->user()->isAdmin())
                            <form action="{{ route('reservasi.status', $r) }}" method="POST" class="d-flex gap-1">
                                @csrf @method('PATCH')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="menunggu" @selected($r->status==='menunggu')>Menunggu</option>
                                    <option value="disetujui" @selected($r->status==='disetujui')>Disetujui</option>
                                    <option value="ditolak" @selected($r->status==='ditolak')>Ditolak</option>
                                </select>
                            </form>
                        @elseif($r->status === 'menunggu')
                            <form action="{{ route('reservasi.destroy', $r) }}" method="POST" class="form-hapus">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-x-circle"></i> Batalkan
                                </button>
                            </form>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-3">Belum ada data reservasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $reservasis->links() }}
</div>
@endsection
