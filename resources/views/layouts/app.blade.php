<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        
        <div class="min-h-screen flex bg-gray-100 dark:bg-gray-900">
            
            @include('layouts._sidebar')


            <div class="flex-1 flex flex-col">
                
                @include('layouts.navigation')

                <main class="flex-grow p-6">
                    @if (isset($header))
                        <header class="mb-6">
                            <div class="max-w-7xl mx-auto">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    {{ $slot }}
                </main>

            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('scripts')
    </body>
</html>