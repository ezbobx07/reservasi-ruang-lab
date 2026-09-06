@extends('layouts.app')
@section('title', 'Masuk')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-5">
        <div class="card shadow-sm mt-4">
            <div class="card-body p-4">
                <h4 class="mb-3 text-center"><i class="bi bi-box-arrow-in-right"></i> Masuk</h4>
                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kata Sandi</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="8">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>
                <p class="text-center mt-3 mb-0 small">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                </p>
                <p class="text-center text-muted small mt-2">
                    Demo admin: admin@lab.test / password<br>
                    Demo user: budi@lab.test / password
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
