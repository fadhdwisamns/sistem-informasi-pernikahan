<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Data Pernikahan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                    <div>
                        <x-input-label :value="__('Nomor Akta Nikah')" />
                        <p class="mt-1 text-sm">{{ $pernikahan->no_akta ?? '-' }}</p>
                    </div>

                    <div>
                        <x-input-label :value="__('Tanggal Akad')" />
                        <p class="mt-1 text-sm">{{ $pernikahan->tanggal_akad ?? '-' }}</p>
                    </div>

                    <div>
                        <x-input-label :value="__('Nama Suami')" />
                        <p class="mt-1 text-sm">{{ $pernikahan->nama_suami }}</p>
                    </div>

                    <div>
                        <x-input-label :value="__('NIK Suami')" />
                        <p class="mt-1 text-sm">{{ $pernikahan->nik_suami ?? '-' }}</p>
                    </div>

                    <div>
                        <x-input-label :value="__('Nama Istri')" />
                        <p class="mt-1 text-sm">{{ $pernikahan->nama_istri }}</p>
                    </div>

                    <div>
                        <x-input-label :value="__('NIK Istri')" />
                        <p class="mt-1 text-sm">{{ $pernikahan->nik_istri ?? '-' }}</p>
                    </div>

                    <div>
                        <x-input-label :value="__('Tempat Pernikahan')" />
                        <p class="mt-1 text-sm">{{ $pernikahan->tempat_pernikahan ?? '-' }}</p>
                    </div>

                    <div>
                        <x-input-label :value="__('Status Verifikasi')" />
                        <p class="mt-1 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium
                                @if($pernikahan->status_verifikasi == 'disetujui')
                                    bg-green-100 text-green-700
                                @elseif($pernikahan->status_verifikasi == 'ditolak')
                                    bg-red-100 text-red-700
                                @else
                                    bg-yellow-100 text-yellow-700
                                @endif
                            ">
                                {{ ucfirst($pernikahan->status_verifikasi ?? 'Belum Diverifikasi') }}
                            </span>
                        </p>
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('petugas-kua.pernikahan.index') }}" class="text-blue-600 hover:underline">
                            ← Kembali ke daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
