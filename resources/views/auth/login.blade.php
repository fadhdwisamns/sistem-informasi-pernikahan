<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:flex-row items-center justify-center bg-gray-100 dark:bg-gray-900">
        
        <div class="hidden sm:flex w-full sm:w-1/2 h-screen items-center justify-center bg-gradient-to-br from-teal-500 to-cyan-600 p-12 text-white">
            <div class="text-center">
                <div class="mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 01-9-9 1.89 1.89 0 01.305-1.025 2.25 2.25 0 013.84-1.288A9 9 0 0112 3a9 9 0 019 9 1.89 1.89 0 01-.305 1.025 2.25 2.25 0 01-3.84 1.288A9 9 0 0112 21z" />
                    </svg>
                </div>
                <h1 class="font-bold text-3xl xl:text-4xl mb-2">Sistem Informasi Pelaporan</h1>
                <p class="text-lg xl:text-xl font-medium">Pernikahan & Perceraian</p>
                <p class="mt-4 text-cyan-200">Kemenag Kuantan Singingi</p>
            </div>
        </div>

        <div class="w-full sm:w-1/2 flex justify-center items-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                <div class="text-center sm:text-left mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Selamat Datang Kembali</h2>
                    <p class="text-gray-600 dark:text-gray-400">Silakan masuk untuk melanjutkan</p>
                </div>
                
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-input-label for="username" :value="__('Username')" class="dark:text-gray-300" />
                        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300"/>
                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-cyan-600 shadow-sm focus:ring-cyan-500 dark:focus:ring-cyan-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-primary-button class="ml-3 bg-cyan-600 hover:bg-cyan-700 focus:bg-cyan-700 active:bg-cyan-800 focus:ring-cyan-500">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>