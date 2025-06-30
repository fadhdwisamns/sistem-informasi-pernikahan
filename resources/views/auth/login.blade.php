<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <style>
        /* Menggunakan font dari Google Fonts */
        body {
            font-family: 'Figtree', sans-serif;
        }

        /* Container utama dengan background image */
        .full-page-background {
            background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh; /* Memastikan tinggi minimal seukuran layar */
            position: relative;
        }

        /* Lapisan overlay gelap di atas background */
        .full-page-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        /* Konten login agar berada di atas overlay */
        .login-container {
            position: relative;
            z-index: 2;
        }

        /* Card login */
        .login-card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
        }

        /* Panel kiri dengan background gradient */
        .info-panel {
            background-image: linear-gradient(to bottom right, #14b8a6, #06b6d4); /* Gradient from-teal-500 to-cyan-600 */
        }
        
        /* Mengubah warna primer Bootstrap agar sesuai dengan tema Anda */
        .btn-primary {
            --bs-btn-bg: #06b6d4; /* cyan-600 */
            --bs-btn-border-color: #06b6d4;
            --bs-btn-hover-bg: #0891b2; /* cyan-700 */
            --bs-btn-hover-border-color: #0891b2;
            --bs-btn-active-bg: #0e7490; /* cyan-800 */
            --bs-btn-active-border-color: #0e7490;
        }
        .form-check-input:checked {
            background-color: #06b6d4;
            border-color: #06b6d4;
        }
        .form-control:focus {
            border-color: #06b6d4;
            box-shadow: 0 0 0 0.25rem rgba(6, 182, 212, 0.25);
        }
    </style>
</head>
<body class="antialiased">
    <div class="full-page-background d-flex align-items-center justify-content-center">
        <div class="container login-container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card login-card shadow-lg">
                        <div class="row g-0">
                            
                            {{-- Panel Kiri (Informasi) --}}
                            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center text-white p-5 info-panel">
                                <div class="text-center">
                                    <div class="mb-4">
                                        {{-- LOGO KEMENAG --}}
                                        <img src="{{ asset('images/logo-kemenag.png') }}" alt="Logo Kemenag" style="width: 100px; height: auto;">
                                    </div>
                                    {{-- JUDUL SISTEM --}}
                                    <h1 class="h2 fw-bold mb-3">
                                        Sistem Informasi Pernikahan & Perceraian
                                    </h1>
                                    <p class="fs-5 opacity-75">Kemenag Kuantan Singingi</p>
                                </div>
                            </div>

                            {{-- Panel Kanan (Form Login) --}}
                            <div class="col-md-6 d-flex align-items-center bg-light">
                                <div class="card-body p-4 p-lg-5">
                                    
                                    <div class="text-center mb-5">
                                        <h2 class="h1 fw-bold">Selamat Datang</h2>
                                        <p class="text-muted fs-5">Silakan masuk untuk melanjutkan</p>
                                    </div>
                                    
                                    @if (session('status'))
                                        <div class="alert alert-success mb-4" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-floating mb-3">
                                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" placeholder="Username">
                                            <label for="username">Username</label>
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                            <label for="password">Password</label>
                                             @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                                <label class="form-check-label" for="remember_me">
                                                    {{ __('Remember me') }}
                                                </label>
                                            </div>
                                            @if (Route::has('password.request'))
                                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                                    {{ __('Forgot your password?') }}
                                                </a>
                                            @endif
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                                {{ __('Log in') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>