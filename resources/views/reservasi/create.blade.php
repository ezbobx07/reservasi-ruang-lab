@extends('layouts.app')
@section('title', 'Ajukan Reservasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="bi bi-calendar-plus"></i> Ajukan Reservasi Ruang</div>
            <div class="card-body">
                <form method="POST" action="{{ route('reservasi.store') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Ruang <span class="text-danger">*</span></label>
                        <select name="ruang_id" class="form-select @error('ruang_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Ruang --</option>
                            @foreach($ruangs as $ruang)
                                <option value="{{ $ruang->id }}" @selected(old('ruang_id') == $ruang->id)>
                                    {{ $ruang->nama }} ({{ $ruang->kode }}) - kapasitas {{ $ruang->kapasitas }}
                                </option>
                            @endforeach
                        </select>
                        @error('ruang_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal') }}" min="{{ now()->toDateString() }}" required>
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror"
                                   value="{{ old('waktu_mulai') }}" required>
                            @error('waktu_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                            <input type="time" name="waktu_selesai" class="form-control @error('waktu_selesai') is-invalid @enderror"
                                   value="{{ old('waktu_selesai') }}" required>
                            @error('waktu_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keperluan <span class="text-danger">*</span></label>
                        <input type="text" name="keperluan" class="form-control @error('keperluan') is-invalid @enderror"
                               value="{{ old('keperluan') }}" required maxlength="255" placeholder="Contoh: Praktikum Basis Data">
                        @error('keperluan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Ajukan</button>
                    <a href="{{ route('reservasi.index') }}" class="btn btn-outline-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
