<x-app-layout>
    {{-- Slot untuk Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Konten Utama Dashboard --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Pesan Selamat Datang --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Selamat Datang Kembali, <span class="font-bold">{{ auth()->user()->name }}</span>!
                    <p class="text-sm text-gray-600 dark:text-gray-400">Anda login sebagai <span class="font-medium capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</span>.</p>
                </div>
            </div>

            {{-- ======================================================================= --}}
            {{-- TAMPILAN UNTUK ADMIN --}}
            {{-- ======================================================================= --}}
            @if(auth()->user()->role == 'admin')
                {{-- Bagian Kartu Statistik Admin --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900 rounded-full"><svg class="h-7 w-7 text-indigo-500 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg></div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Pernikahan Bulan Ini</p>
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pernikahan_bulan_ini }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 p-3 bg-rose-100 dark:bg-rose-900 rounded-full"><svg class="h-7 w-7 text-rose-500 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Perceraian Bulan Ini</p>
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $perceraian_bulan_ini }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 p-3 bg-amber-100 dark:bg-amber-900 rounded-full"><svg class="h-7 w-7 text-amber-500 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg></div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Menunggu Verifikasi</p>
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $menunggu_verifikasi }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 p-3 bg-cyan-100 dark:bg-cyan-900 rounded-full"><svg class="h-7 w-7 text-cyan-500 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg></div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total KUA Terdaftar</p>
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $total_kua }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

            {{-- ======================================================================= --}}
            {{-- TAMPILAN UNTUK PETUGAS KUA --}}
            {{-- ======================================================================= --}}
            @elseif(auth()->user()->role == 'petugas_kua')
                {{-- Bagian Kartu Statistik Petugas KUA --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg"><div class="flex items-center space-x-4"><div class="flex-shrink-0 p-3 bg-slate-100 dark:bg-slate-900 rounded-full"><svg class="h-7 w-7 text-slate-500 dark:text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div><div><p class="text-sm text-gray-500 dark:text-gray-400">Total Input Anda</p><h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $total_input_kua }}</h3></div></div></div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg"><div class="flex items-center space-x-4"><div class="flex-shrink-0 p-3 bg-green-100 dark:bg-green-900 rounded-full"><svg class="h-7 w-7 text-green-500 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div><div><p class="text-sm text-gray-500 dark:text-gray-400">Disetujui</p><h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pernikahan_disetujui }}</h3></div></div></div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg"><div class="flex items-center space-x-4"><div class="flex-shrink-0 p-3 bg-amber-100 dark:bg-amber-900 rounded-full"><svg class="h-7 w-7 text-amber-500 dark:text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div><div><p class="text-sm text-gray-500 dark:text-gray-400">Menunggu</p><h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pernikahan_menunggu }}</h3></div></div></div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg"><div class="flex items-center space-x-4"><div class="flex-shrink-0 p-3 bg-rose-100 dark:bg-rose-900 rounded-full"><svg class="h-7 w-7 text-rose-500 dark:text-rose-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg></div><div><p class="text-sm text-gray-500 dark:text-gray-400">Ditolak</p><h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pernikahan_ditolak }}</h3></div></div></div>
                </div>

            {{-- ======================================================================= --}}
            {{-- TAMPILAN UNTUK PETUGAS PA --}}
            {{-- ======================================================================= --}}
            @elseif(auth()->user()->role == 'petugas_pa')
                {{-- Bagian Kartu Statistik Petugas PA --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg"><div class="flex items-center space-x-4"><div class="flex-shrink-0 p-3 bg-slate-100 dark:bg-slate-900 rounded-full"><svg class="h-7 w-7 text-slate-500 dark:text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div><div><p class="text-sm text-gray-500 dark:text-gray-400">Total Input Anda</p><h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $total_input_pa }}</h3></div></div></div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg"><div class="flex items-center space-x-4"><div class="flex-shrink-0 p-3 bg-green-100 dark:bg-green-900 rounded-full"><svg class="h-7 w-7 text-green-500 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div><div><p class="text-sm text-gray-500 dark:text-gray-400">Disetujui</p><h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $perceraian_disetujui }}</h3></div></div></div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg"><div class="flex items-center space-x-4"><div class="flex-shrink-0 p-3 bg-amber-100 dark:bg-amber-900 rounded-full"><svg class="h-7 w-7 text-amber-500 dark:text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div><div><p class="text-sm text-gray-500 dark:text-gray-400">Menunggu</p><h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $perceraian_menunggu }}</h3></div></div></div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg"><div class="flex items-center space-x-4"><div class="flex-shrink-0 p-3 bg-rose-100 dark:bg-rose-900 rounded-full"><svg class="h-7 w-7 text-rose-500 dark:text-rose-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg></div><div><p class="text-sm text-gray-500 dark:text-gray-400">Ditolak</p><h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $perceraian_ditolak }}</h3></div></div></div>
                </div>
            @endif


            {{-- ======================================================================= --}}
            {{-- BAGIAN BERSAMA: GRAFIK DAN AKTIVITAS (Tampil untuk semua role) --}}
            {{-- ======================================================================= --}}
            @if(in_array(auth()->user()->role, ['admin', 'petugas_kua', 'petugas_pa']))
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                        @if(auth()->user()->role == 'admin')
                            Grafik Tren Pernikahan & Perceraian - {{ date('Y') }}
                        @elseif(auth()->user()->role == 'petugas_kua')
                            Grafik Input Pernikahan & Rujuk Anda - {{ date('Y') }}
                        @else
                            Grafik Input Perceraian Anda - {{ date('Y') }}
                        @endif
                    </h3>
                    <div class="relative h-96">
                        <canvas id="trenChart"></canvas>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                        Aktivitas Terbaru Anda
                    </h3>
                    <div class="space-y-4">
                        @forelse($aktivitas_terbaru as $aktivitas)
                        <div class="flex items-start space-x-4 group">
                            <div class="flex-shrink-0 mt-1">
                                <span class="h-10 w-10 rounded-full flex items-center justify-center text-white {{ $aktivitas->jenis_kegiatan == 'Pernikahan' ? 'bg-indigo-500' : 'bg-rose-500' }}">
                                    @if($aktivitas->jenis_kegiatan == 'Pernikahan')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                    @else
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    @endif
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-800 dark:text-gray-200">
                                    Input Data {{ $aktivitas->jenis_kegiatan }} baru antara <span class="font-semibold">{{ $aktivitas->pihak1 }}</span> & <span class="font-semibold">{{ $aktivitas->pihak2 }}</span>.
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $aktivitas->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-center text-gray-500 dark:text-gray-400 py-4">Belum ada aktivitas terbaru.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
    
    {{-- Script untuk Chart.js (hanya dimuat jika ada role yang diizinkan) --}}
    @if(in_array(auth()->user()->role, ['admin', 'petugas_kua', 'petugas_pa']))
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvasElement = document.getElementById('trenChart');
            if (!canvasElement) { return; }

            const ctx = canvasElement.getContext('2d');
            
            const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            let gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
            let labelColor = isDarkMode ? '#9CA3AF' : '#4B5563';

            const trenChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chart_labels),
                    // LOGIKA BARU: Menggunakan data berdasarkan role
                    datasets: @if(auth()->user()->role == 'admin')
                        [
                            {
                                label: 'Pernikahan',
                                data: @json($pernikahan_data),
                                borderColor: 'rgba(99, 102, 241, 1)',
                                backgroundColor: 'rgba(99, 102, 241, 0.2)',
                                tension: 0.4, fill: true
                            },
                            {
                                label: 'Perceraian',
                                data: @json($perceraian_data),
                                borderColor: 'rgba(244, 63, 94, 1)',
                                backgroundColor: 'rgba(244, 63, 94, 0.2)',
                                tension: 0.4, fill: true
                            }
                        ]
                    @else
                        // Untuk Petugas KUA & PA, data sudah disiapkan dalam format array dataset
                        @json($chart_datasets)
                    @endif
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor, drawBorder: false },
                            ticks: {
                                color: labelColor,
                                callback: function(value) { if (Number.isInteger(value)) { return value; } }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: labelColor }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: labelColor,
                                usePointStyle: true,
                                boxWidth: 8,
                            }
                        }
                    },
                    interaction: { intersect: false, mode: 'index' },
                }
            });

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                gridColor = event.matches ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
                labelColor = event.matches ? '#9CA3AF' : '#4B5563';
                trenChart.options.scales.y.grid.color = gridColor;
                trenChart.options.scales.y.ticks.color = labelColor;
                trenChart.options.scales.x.ticks.color = labelColor;
                trenChart.options.plugins.legend.labels.color = labelColor;
                trenChart.update();
            });
        });
    </script>
    @endpush
    @endif
</x-app-layout>