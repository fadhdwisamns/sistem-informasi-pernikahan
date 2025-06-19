<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Optional: Add a smooth transition for dark/light mode changes if not handled by app.css */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        /* Mengatur background image untuk seluruh halaman */
        .full-page-background {
            background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center relative full-page-background">
        <div class="absolute inset-0 bg-black opacity-60"></div>

        <div class="relative z-10 w-full max-w-xl bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
            <div class="hidden md:flex flex-col items-center justify-center bg-gradient-to-br from-teal-500 to-cyan-600 p-8 lg:p-12 text-white md:w-1/2">
                <div class="text-center">
                    <div class="mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 01-9-9 1.89 1.89 0 01.305-1.025 2.25 2.25 0 013.84-1.288A9 9 0 0112 3a9 9 0 019 9 1.89 1.89 0 01-.305 1.025 2.25 2.25 0 01-3.84 1.288A9 9 0 0112 21z" />
                        </svg>
                    </div>
                    <h1 class="font-extrabold text-4xl lg:text-5xl mb-3 leading-tight drop-shadow-md">Sistem Informasi Pelaporan</h1>
                    <p class="text-xl lg:text-2xl font-semibold opacity-90">Pernikahan & Perceraian</p>
                    <p class="mt-6 text-cyan-200 text-lg opacity-80">Kemenag Kuantan Singingi</p>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-10 sm:p-12 lg:p-16 flex flex-col justify-center">
                <div class="text-center mb-8">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white">Selamat Datang Kembali</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-400 text-lg">Silakan masuk untuk melanjutkan</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <x-input-label for="username" :value="__('Username')" class="dark:text-gray-300 mb-2" />
                        <x-text-input id="username" class="block w-full px-5 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-base" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300 mb-2"/>
                        <x-text-input id="password" class="block w-full px-5 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-base"
                                      type="password"
                                      name="password"
                                      required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-cyan-600 shadow-sm focus:ring-cyan-500 dark:focus:ring-cyan-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-cyan-600 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 dark:focus:ring-offset-gray-800 font-medium" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center justify-end">
                        <x-primary-button class="w-full justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-lg text-lg font-semibold text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>