<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Data Rujuk Baru') }}
        </h2>
    </x-slot>

    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"> {{-- Menggunakan shadow-xl --}}
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Validasi Error --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg shadow">
                            <strong class="font-bold">Oops! Terjadi kesalahan pada input Anda.</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('petugas-kua.rujuk.store') }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf

                        

                        {{-- Input Tanggal Rujuk --}}
                        <div>
                            <x-input-label for="tanggal_rujuk" :value="__('Tanggal Rujuk')" />
                            <x-text-input id="tanggal_rujuk" name="tanggal_rujuk" type="text" class="mt-1 block w-full" :value="old('tanggal_rujuk')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_rujuk')" />
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="font-semibold text-lg">Data Suami</h3>
                        <div>
                            <x-input-label for="nama_suami" :value="__('Nama Suami')" />
                            <x-text-input id="nama_suami" name="nama_suami" type="text" class="mt-1 block w-full" :value="old('nama_suami')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_suami')" />
                        </div>
                        <div>
                            <x-input-label for="nik_suami" :value="__('NIK Suami')" />
                            <x-text-input id="nik_suami" name="nik_suami" type="text" class="mt-1 block w-full" :value="old('nik_suami')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nik_suami')" />
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="font-semibold text-lg">Data Istri</h3>
                        <div>
                            <x-input-label for="nama_istri" :value="__('Nama Istri')" />
                            <x-text-input id="nama_istri" name="nama_istri" type="text" class="mt-1 block w-full" :value="old('nama_istri')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_istri')" />
                        </div>
                        <div>
                            <x-input-label for="nik_istri" :value="__('NIK Istri')" />
                            <x-text-input id="nik_istri" name="nik_istri" type="text" class="mt-1 block w-full" :value="old('nik_istri')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nik_istri')" />
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        {{-- Input Tempat Rujuk --}}
                        <div>
                            <x-input-label for="tempat_rujuk" :value="__('Tempat Rujuk')" />
                            <x-text-input id="tempat_rujuk" name="tempat_rujuk" type="text" class="mt-1 block w-full" :value="old('tempat_rujuk')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tempat_rujuk')" />
                        </div>
                        <div class="mt-4">
                        <x-input-label for="desa" :value="__('Desa/Kelurahan')" />
                        <x-text-input id="desa" name="desa" type="text" class="mt-1 block w-full" :value="old('desa')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('desa')" />
                    </div>
                        {{-- Input File Akta Cerai --}}
                        <div>
                            <x-input-label for="file_akta_cerai" :value="__('Upload Akta Cerai (PDF/Gambar)')" />
                            <input id="file_akta_cerai" name="file_akta_cerai" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/50 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800">
                            <x-input-error class="mt-2" :messages="$errors->get('file_akta_cerai')" />
                        </div>

                        {{-- Tombol Simpan dan Batal --}}

                        <div class="flex items-center justify-end gap-4 mt-6"> {{-- Tambahkan justify-end untuk menempatkan tombol di kanan --}}
                            <a href="{{ route('petugas-kua.rujuk.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Data Rujuk') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Flatpickr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#tanggal_rujuk", {
            dateFormat: "Y-m-d", // Format sesuai dengan yang biasa digunakan di database (YYYY-MM-DD)
            defaultDate: "{{ old('tanggal_rujuk') ? old('tanggal_rujuk') : date('Y-m-d') }}" // Set default ke hari ini jika tidak ada old value
        });
    </script>
</x-app-layout>