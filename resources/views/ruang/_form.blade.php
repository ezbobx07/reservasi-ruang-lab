@php $ruang = $ruang ?? null; @endphp

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Kode Ruang <span class="text-danger">*</span></label>
        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
               value="{{ old('kode', $ruang->kode ?? '') }}" required maxlength="20" placeholder="Contoh: LAB-01">
        @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Nama Ruang <span class="text-danger">*</span></label>
        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
               value="{{ old('nama', $ruang->nama ?? '') }}" required maxlength="100">
        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Kapasitas (orang) <span class="text-danger">*</span></label>
        <input type="number" name="kapasitas" min="1" class="form-control @error('kapasitas') is-invalid @enderror"
               value="{{ old('kapasitas', $ruang->kapasitas ?? '') }}" required>
        @error('kapasitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Lokasi <span class="text-danger">*</span></label>
        <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
               value="{{ old('lokasi', $ruang->lokasi ?? '') }}" required maxlength="150">
        @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Fasilitas</label>
        <textarea name="fasilitas" rows="2" class="form-control @error('fasilitas') is-invalid @enderror">{{ old('fasilitas', $ruang->fasilitas ?? '') }}</textarea>
        @error('fasilitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Foto Ruang @if(!$ruang) <span class="text-danger">(opsional)</span>@endif</label>
        <input type="file" name="foto" accept="image/png, image/jpeg" class="form-control @error('foto') is-invalid @enderror">
        <div class="form-text">Format JPG/PNG, maksimal 2MB.</div>
        @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if($ruang && $ruang->foto)
            <img src="{{ $ruang->foto_url }}" class="mt-2 rounded" style="max-height:120px" alt="Foto saat ini">
        @endif
    </div>
</div>
