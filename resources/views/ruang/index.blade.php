@extends('layouts.app')
@section('title', 'Data Ruang')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h3 class="mb-0"><i class="bi bi-door-open"></i> Data Ruang Laboratorium</h3>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('ruang.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Ruang
    </a>
    @endif
</div>

<form method="GET" action="{{ route('ruang.index') }}" class="row g-2 mb-4">
    <div class="col-9 col-md-4">
        <input type="text" name="q" class="form-control" placeholder="Cari nama, kode, atau lokasi..." value="{{ $keyword }}">
    </div>
    <div class="col-3 col-md-2">
        <button type="submit" class="btn btn-outline-secondary w-100"><i class="bi bi-search"></i> Cari</button>
    </div>
</form>

<div class="row g-3">
    @forelse($ruangs as $ruang)
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
            @if($ruang->foto)
                <img src="{{ $ruang->foto_url }}" class="card-img-top" style="height:160px;object-fit:cover" alt="Foto {{ $ruang->nama }}">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height:160px;">
                    <i class="bi bi-image text-muted fs-1"></i>
                </div>
            @endif
            <div class="card-body">
                <h5 class="card-title mb-1">{{ $ruang->nama }}</h5>
                <span class="badge bg-secondary mb-2">{{ $ruang->kode }}</span>
                <p class="card-text small mb-1"><i class="bi bi-geo-alt"></i> {{ $ruang->lokasi }}</p>
                <p class="card-text small mb-1"><i class="bi bi-people"></i> Kapasitas: {{ $ruang->kapasitas }} orang</p>
                @if($ruang->fasilitas)
                    <p class="card-text small text-muted">{{ $ruang->fasilitas }}</p>
                @endif
            </div>
            @if(auth()->user()->isAdmin())
            <div class="card-footer bg-white d-flex gap-2">
                <a href="{{ route('ruang.edit', $ruang) }}" class="btn btn-sm btn-outline-primary flex-fill">
                    <i class="bi bi-pencil"></i> Ubah
                </a>
                <form action="{{ route('ruang.destroy', $ruang) }}" method="POST" class="form-hapus flex-fill">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">Belum ada data ruang yang cocok.</div>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $ruangs->links() }}
</div>
@endsection
