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
                                    <div class="mb-5">
                                        {{-- Ganti dengan logo Anda --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16">
                                            <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.06.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.952-.325-1.882-.6-2.837-.855A1.117 1.117 0 0 0 8.528 1.5a1.117 1.117 0 0 0-.832.09zM4.535 2.066A51.319 51.319 0 0 1 8 1.73a51.319 51.319 0 0 1 3.465.336c.82.26 1.543.561 2.155.885a1.002 1.002 0 0 1 .523.892c.482 3.636-.549 6.34-1.887 8.065a9.728 9.728 0 0 1-2.088 2.016c-.332.219-.64.382-.9.5-.145.065-.25.097-.313.11a.49.49 0 0 1-.09.016a.49.49 0 0 1-.09-.016c-.063-.013-.168-.045-.313-.11-.26-.118-.568-.281-.9-.5a9.729 9.729 0 0 1-2.088-2.016c-1.338-1.725-2.37-4.43-1.887-8.065a1 1 0 0 1 .523-.892c.612-.324 1.335-.625 2.155-.885z"/>
                                            <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.96a.5.5 0 1 1-.966.189l-.385-1.96a1.5 1.5 0 1 1 1.966-1.601z"/>
                                        </svg>                                   
                                    </div>
                                    <h1 class="display-5 fw-bold mb-3">Sistem Informasi Pelaporan</h1>
                                    <p class="fs-4 fw-semibold opacity-75">Pernikahan & Perceraian</p>
                                    <p class="mt-4 fs-5 opacity-75">Kemenag Kuantan Singingi</p>
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