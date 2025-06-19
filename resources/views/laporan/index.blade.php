<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Filter --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <form action="{{ route('laporan.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="bulan" value="{{ __('Bulan') }}" />
                            <select id="bulan" name="bulan" class="block w-full mt-1 rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300">
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="tahun" value="{{ __('Tahun') }}" />
                            <select id="tahun" name="tahun" class="block w-full mt-1 rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <x-primary-button class="w-full justify-center">
                                {{ __('Filter') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Ringkasan Kartu --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $cards = [
                        ['label' => 'Total Pernikahan', 'value' => $totalPernikahan, 'color' => 'indigo', 'icon' => '💍'],
                        ['label' => 'Total Rujuk', 'value' => $totalRujuk, 'color' => 'purple', 'icon' => '❤️'],
                        ['label' => 'Total Perceraian', 'value' => $totalPerceraian, 'color' => 'red', 'icon' => '⚠️'],
                    ];
                @endphp

                @foreach($cards as $card)
                    <div class="bg-gradient-to-br from-{{ $card['color'] }}-400 to-{{ $card['color'] }}-600 text-white p-6 rounded-lg shadow hover:scale-105 transform transition duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-lg font-semibold">{{ $card['label'] }}</p>
                                <p class="text-4xl font-bold mt-1">{{ $card['value'] }}</p>
                            </div>
                            <div class="text-5xl">
                                {{ $card['icon'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pie Chart Ringkasan --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Distribusi Total Data</h3>
                <div class="w-full h-[300px]">
                    <canvas id="ringkasanChart" class="w-full h-full"></canvas>
                </div>
            </div>

            {{-- Statistik Bulan Ini --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
                    Statistik Bulan {{ $months[(int)$selectedMonth] }} {{ $selectedYear }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    @php
                        $stats = [
                            ['label' => 'Pernikahan Bulan Ini', 'value' => $laporanPernikahanBulanIni],
                            ['label' => 'Rujuk Bulan Ini', 'value' => $laporanRujukBulanIni],
                            ['label' => 'Perceraian Bulan Ini', 'value' => $laporanPerceraianBulanIni],
                        ];
                    @endphp

                    @foreach($stats as $stat)
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md shadow hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $stat['label'] }}</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stat['value'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="w-full h-[300px]">
                    <canvas id="bulananChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ringkasanCtx = document.getElementById('ringkasanChart').getContext('2d');
        new Chart(ringkasanCtx, {
            type: 'pie',
            data: {
                labels: ['Pernikahan', 'Rujuk', 'Perceraian'],
                datasets: [{
                    data: [{{ $totalPernikahan }}, {{ $totalRujuk }}, {{ $totalPerceraian }}],
                    backgroundColor: ['#6366f1', '#8b5cf6', '#ef4444'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: '#374151' }
                    }
                }
            }
        });

        const bulananCtx = document.getElementById('bulananChart').getContext('2d');
        new Chart(bulananCtx, {
            type: 'bar',
            data: {
                labels: ['Pernikahan', 'Rujuk', 'Perceraian'],
                datasets: [{
                    label: 'Jumlah Bulan Ini',
                    data: [{{ $laporanPernikahanBulanIni }}, {{ $laporanRujukBulanIni }}, {{ $laporanPerceraianBulanIni }}],
                    backgroundColor: ['#6366f1', '#8b5cf6', '#ef4444'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#374151' },
                        grid: { color: '#e5e7eb' }
                    },
                    x: {
                        ticks: { color: '#374151' },
                        grid: { color: '#e5e7eb' }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: '#374151' }
                    }
                }
            }
        });
    </script>
</x-app-layout>
