<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Data Rujuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-6">Informasi Rujuk</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                        {{-- Field No Surat Rujuk --}}
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Nomor Surat Rujuk:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $rujuk->no_surat_rujuk }}</p>
                        </div>

                        {{-- Field Tanggal Rujuk --}}
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Tanggal Rujuk:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ \Carbon\Carbon::parse($rujuk->tanggal_rujuk)->translatedFormat('d F Y') }}</p>
                        </div>

                        {{-- Field Status --}}
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Status:</p>
                            <p class="mt-1">
                                @if($rujuk->status == 'Disetujui')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $rujuk->status }}
                                    </span>
                                @elseif($rujuk->status == 'Ditolak')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ $rujuk->status }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $rujuk->status }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        {{-- Field Tempat Rujuk --}}
                        <div class="md:col-span-2"> {{-- Membentang 2 kolom --}}
                            <p class="font-medium text-gray-500 dark:text-gray-400">Tempat Rujuk:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $rujuk->tempat_rujuk }}</p>
                        </div>
                    </div>

                    <hr class="my-8 border-gray-200 dark:border-gray-700">

                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-6">Data Suami</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Nama Suami:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $rujuk->nama_suami }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">NIK Suami:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $rujuk->nik_suami }}</p>
                        </div>
                    </div>

                    <hr class="my-8 border-gray-200 dark:border-gray-700">

                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-6">Data Istri</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">Nama Istri:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $rujuk->nama_istri }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-500 dark:text-gray-400">NIK Istri:</p>
                            <p class="text-gray-900 dark:text-gray-100 mt-1">{{ $rujuk->nik_istri }}</p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('petugas-kua.rujuk.edit', $rujuk) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 dark:bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 dark:hover:bg-yellow-500 focus:bg-yellow-600 dark:focus:bg-yellow-500 active:bg-yellow-700 dark:active:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            {{ __('Edit Data') }}
                        </a>
                        <a href="{{ route('petugas-kua.rujuk.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Kembali') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>