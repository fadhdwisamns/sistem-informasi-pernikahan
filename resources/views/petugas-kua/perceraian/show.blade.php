<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Data Perceraian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-6">Informasi Putusan Cerai</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                        {{-- Field No Putusan --}}
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Nomor Putusan:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->no_putusan }}</p>
                        </div>

                        {{-- Field Pengadilan Agama --}}
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Pengadilan Agama:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->masterPa->nama_pa ?? 'N/A' }}</p>
                        </div>

                        {{-- Field Tanggal Putusan --}}
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Tanggal Putusan:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ \Carbon\Carbon::parse($perceraian->tanggal_putusan)->translatedFormat('d F Y') }}</p>
                        </div>
                        
                        {{-- Field Tempat Cerai (Sidang) --}}
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Tempat Sidang Cerai:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->tempat_cerai }}</p>
                        </div>
                        
                        {{-- Field Penyebab Cerai --}}
                        <div class="md:col-span-2">
                            <p class="font-medium text-gray-500 dark:text-gray-400">Penyebab Cerai:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->penyebab_cerai ?? '-' }}</p>
                        </div>
                    </div>

                    <hr class="my-8 border-gray-200 dark:border-gray-700">

                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-6">Data Pihak</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Nama Penggugat:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->nama_penggugat }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Nama Tergugat:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->nama_tergugat }}</p>
                        </div>
                    </div>

                    <hr class="my-8 border-gray-200 dark:border-gray-700">

                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-6">Status Verifikasi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Status:</p>
                            <p class="mt-1">
                                @php
                                    $statusClass = [
                                        'menunggu' => 'bg-yellow-100 text-yellow-800',
                                        'disetujui' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-800',
                                    ][$perceraian->status_verifikasi] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($perceraian->status_verifikasi) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Diverifikasi Oleh:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->verifiedBy->name ?? 'Belum Diverifikasi' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="font-medium text-gray-500 dark:text-gray-400">Catatan Verifikasi:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->catatan_verifikasi ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Dibuat Oleh:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->createdBy->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Dibuat Pada:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ \Carbon\Carbon::parse($perceraian->created_at)->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        {{-- Link Edit Data - Gunakan $routePrefix --}}
                        <a href="{{ route($routePrefix . '.perceraians.edit', $perceraian) }}" {{-- UBAH INI: $userRolePrefix menjadi $routePrefix --}}
                           class="inline-flex items-center px-4 py-2 bg-yellow-500 dark:bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 dark:hover:bg-yellow-500 focus:bg-yellow-600 dark:focus:bg-yellow-500 active:bg-yellow-700 dark:active:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            {{ __('Edit Data') }}
                        </a>
                        {{-- Link Kembali - Gunakan $routePrefix --}}
                        <a href="{{ route($routePrefix . '.perceraians.index') }}" {{-- UBAH INI: $userRolePrefix menjadi $routePrefix --}}
                           class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Kembali') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>