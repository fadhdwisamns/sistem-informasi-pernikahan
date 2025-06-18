<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white tracking-tight">
            📋 Manajemen Data Pernikahan
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Alert sukses --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    class="flex items-center justify-between bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded-md shadow transition ease-in-out duration-300">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-700 dark:hover:text-white">
                        ✕
                    </button>
                </div>
            @endif

            {{-- Filter --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form method="GET" action="{{ route('petugas-kua.pernikahan.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <div class="md:col-span-3 lg:col-span-2">
                            <x-input-label for="search" value="Cari Data" />
                            <x-text-input id="search" name="search" type="text" class="w-full mt-1"
                                :value="request('search')" placeholder="Nama, No. Akta..." />
                        </div>
                        <div>
                            <x-input-label for="bulan" value="Bulan" />
                            <select name="bulan" id="bulan"
                                class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-700">
                                <option value="">Semua</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <x-input-label for="tahun" value="Tahun" />
                            <select name="tahun" id="tahun"
                                class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-700">
                                <option value="">Semua</option>
                                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <x-input-label for="status" value="Status" />
                            <select name="status" id="status"
                                class="w-full mt-1 rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-700">
                                <option value="">Semua</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <x-primary-button>Filter</x-primary-button>
                            <a href="{{ route('petugas-kua.pernikahan.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Tabel --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">📄 Daftar Data Pernikahan</h3>
                    @if(auth()->user()->role == 'petugas_kua')
                        <a href="{{ route('petugas-kua.pernikahan.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-black text-sm font-medium rounded-md shadow transition">
                        + Tambah Data
                    </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 dark:border-gray-700 rounded-md overflow-hidden">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm uppercase">
                            <tr>
                                <th class="p-3 text-left">No</th>
                                <th class="p-3 text-left">No. Akta</th>
                                <th class="p-3 text-left">Tgl. Akad</th>
                                <th class="p-3 text-left">Pasangan</th>
                                @if(auth()->user()->role == 'admin')
                                    <th class="p-3 text-left">KUA</th>
                                @endif
                                <th class="p-3 text-center">Status</th>
                                <th class="p-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($pernikahans as $key => $pernikahan)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-3">{{ $pernikahans->firstItem() + $key }}</td>
                                    <td class="p-3 font-mono">{{ $pernikahan->no_akta }}</td>
                                    <td class="p-3">{{ \Carbon\Carbon::parse($pernikahan->tanggal_akad)->isoFormat('D MMM YYYY') }}</td>
                                    <td class="p-3">
                                        <div>{{ $pernikahan->nama_suami }}</div>
                                        <div class="text-sm text-gray-500">{{ $pernikahan->nama_istri }}</div>
                                    </td>
                                    @if(auth()->user()->role == 'admin')
                                        <td class="p-3">{{ $pernikahan->kua->nama_kua }}</td>
                                    @endif
                                    <td class="p-3 text-center">
                                        @php
                                            $statusColors = [
                                                'disetujui' => 'green',
                                                'ditolak' => 'red',
                                                'menunggu' => 'yellow'
                                            ];
                                            $color = $statusColors[$pernikahan->status_verifikasi] ?? 'gray';
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                            {{ ucfirst($pernikahan->status_verifikasi) }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="flex gap-2">
                                            <a href="{{ route('petugas-kua.pernikahan.show', $pernikahan) }}" title="Lihat Detail" class="text-gray-600 hover:text-indigo-600">
                                                👁
                                            </a>
                                            <a href="{{ route('petugas-kua.pernikahan.edit', $pernikahan) }}" title="Edit"
                                                class="text-blue-600 hover:text-blue-800">
                                                ✏️
                                            </a>
                                            <form action="{{ route('petugas-kua.pernikahan.destroy', $pernikahan) }}"
                                                method="POST" onsubmit="return confirm('Hapus data ini secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                                    🗑
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-gray-500">Tidak ada data ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $pernikahans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
