@extends('layouts.app')
@section('title', 'Tambah Ruang')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="bi bi-plus-circle"></i> Tambah Ruang</div>
            <div class="card-body">
                <form method="POST" action="{{ route('ruang.store') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    @include('ruang._form')
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                    <a href="{{ route('ruang.index') }}" class="btn btn-outline-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
