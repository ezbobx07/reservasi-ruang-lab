<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reservasi Lab') - Sistem Reservasi Ruang Laboratorium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background-color: #f5f7fa; }
        .navbar-brand { font-weight: 600; }
        .card { border-radius: .75rem; }
    </style>
</head>
<body>
@auth
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="bi bi-building"></i> Reservasi Lab
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ruang.*') ? 'active fw-bold' : '' }}" href="{{ route('ruang.index') }}">Data Ruang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reservasi.*') ? 'active fw-bold' : '' }}" href="{{ route('reservasi.index') }}">Reservasi</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item d-flex align-items-center me-3 text-light small">
                    <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->nama }}
                    <span class="badge bg-secondary ms-2">{{ ucfirst(auth()->user()->peran) }}</span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endauth

<main class="container my-4">
    @yield('content')
</main>

<footer class="text-center text-muted small py-4">
    &copy; {{ date('Y') }} Sistem Reservasi Ruang Laboratorium — Tugas Remedial Praktikum Pemrograman Web
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('sukses'))
        Swal.fire({ icon: 'success', title: 'Berhasil', text: @json(session('sukses')), timer: 3000, showConfirmButton: false });
    @endif
    @if (session('gagal'))
        Swal.fire({ icon: 'error', title: 'Gagal', text: @json(session('gagal')) });
    @endif
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Periksa kembali isian Anda',
            html: `@foreach ($errors->all() as $error)- {{ $error }}<br>@endforeach`,
        });
    @endif

    /**
     * Konfirmasi sebelum menghapus data (dipakai oleh form dengan class "form-hapus").
     */
    document.querySelectorAll('.form-hapus').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data yang sudah dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545',
            }).then(function (result) {
                if (result.isConfirmed) form.submit();
            });
        });
    });
</script>
@yield('scripts')
</body>
</html>
