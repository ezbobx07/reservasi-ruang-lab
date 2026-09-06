@extends('layouts.app')
@section('title', 'Ubah Ruang')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="bi bi-pencil"></i> Ubah Ruang: {{ $ruang->nama }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('ruang.update', $ruang) }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')
                    @include('ruang._form', ['ruang' => $ruang])
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
                    <a href="{{ route('ruang.index') }}" class="btn btn-outline-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
