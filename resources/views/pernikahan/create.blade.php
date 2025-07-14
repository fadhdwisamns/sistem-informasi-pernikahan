<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Data Pernikahan Baru
        </h2>
    </x-slot>

    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">

                    {{-- Menampilkan Pesan Error --}}
                    @if ($errors->any() || session('error'))
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/50 text-red-700 dark:text-red-300 border border-red-300 dark:border-red-600 rounded-lg shadow-md flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
                                @if(session('error'))
                                    <p class="text-sm">{{ session('error') }}</p>
                                @else
                                    <ul class="mt-2 list-disc list-inside text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('petugas-kua.pernikahan.store') }}" class="space-y-8" enctype="multipart/form-data">
                        @csrf

                        {{-- Panel Data Administrasi & Wali --}}
                        <div class="p-6 bg-gray-50 dark:bg-gray-900/50 rounded-xl ring-1 ring-gray-200 dark:ring-gray-700">
                            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-600 pb-4 mb-6">Data Administrasi & Wali</h3>
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <x-input-label for="tanggal_daftar" value="Tanggal Daftar" />
                                        <x-text-input id="tanggal_daftar" name="tanggal_daftar" type="text" class="mt-1 block w-full date-picker" :value="old('tanggal_daftar')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="tanggal_akad" value="Tanggal Akad" />
                                        <x-text-input id="tanggal_akad" name="tanggal_akad" type="text" class="mt-1 block w-full date-picker" :value="old('tanggal_akad')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="tempat_akad" value="Lokasi Akad" />
                                        <x-text-input id="tempat_akad" name="tempat_akad" type="text" class="mt-1 block w-full" :value="old('tempat_akad')" required />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="wali" value="Jenis Wali" />
                                        <x-text-input id="wali" name="wali" type="text" class="mt-1 block w-full" :value="old('wali')" required placeholder="Contoh: Nasab, Hakim" />
                                    </div>
                                    <div>
                                        <x-input-label for="nama_wali" value="Nama Wali" />
                                        <x-text-input id="nama_wali" name="nama_wali" type="text" class="mt-1 block w-full" :value="old('nama_wali')" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Panel Data Pasangan --}}
                        <div class="p-6 bg-gray-50 dark:bg-gray-900/50 rounded-xl ring-1 ring-gray-200 dark:ring-gray-700">
                            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-600 pb-4 mb-6">Data Pasangan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                                {{-- KOLOM KIRI: DATA SUAMI --}}
                                <div class="space-y-6">
                                    <h4 class="font-semibold text-lg text-gray-700 dark:text-gray-300">Data Suami</h4>
                                    <div>
                                        <x-input-label for="nama_suami" value="Nama Suami" />
                                        <x-text-input id="nama_suami" name="nama_suami" type="text" class="mt-1 block w-full" :value="old('nama_suami')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="nik_suami" value="NIK Suami" />
                                        <x-text-input id="nik_suami" name="nik_suami" type="text" class="mt-1 block w-full" :value="old('nik_suami')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="tempat_lahir_suami" value="Tempat Lahir" />
                                        <x-text-input id="tempat_lahir_suami" name="tempat_lahir_suami" type="text" class="mt-1 block w-full" :value="old('tempat_lahir_suami')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="tanggal_lahir_suami" value="Tanggal Lahir" />
                                        <x-text-input id="tanggal_lahir_suami" name="tanggal_lahir_suami" type="text" class="mt-1 block w-full date-picker" :value="old('tanggal_lahir_suami')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="pendidikan_terakhir_suami" value="Pendidikan Terakhir" />
                                        <x-text-input id="pendidikan_terakhir_suami" name="pendidikan_terakhir_suami" type="text" class="mt-1 block w-full" :value="old('pendidikan_terakhir_suami')" placeholder="Contoh: S1, SMA" />
                                    </div>
                                     <div>
                                        <x-input-label for="nama_ayah_suami" value="Nama Ayah" />
                                        <x-text-input id="nama_ayah_suami" name="nama_ayah_suami" type="text" class="mt-1 block w-full" :value="old('nama_ayah_suami')" />
                                    </div>
                                </div>

                                {{-- KOLOM KANAN: DATA ISTRI --}}
                                <div class="space-y-6">
                                    <h4 class="font-semibold text-lg text-gray-700 dark:text-gray-300">Data Istri</h4>
                                    <div>
                                        <x-input-label for="nama_istri" value="Nama Istri" />
                                        <x-text-input id="nama_istri" name="nama_istri" type="text" class="mt-1 block w-full" :value="old('nama_istri')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="nik_istri" value="NIK Istri" />
                                        <x-text-input id="nik_istri" name="nik_istri" type="text" class="mt-1 block w-full" :value="old('nik_istri')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="tempat_lahir_istri" value="Tempat Lahir" />
                                        <x-text-input id="tempat_lahir_istri" name="tempat_lahir_istri" type="text" class="mt-1 block w-full" :value="old('tempat_lahir_istri')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="tanggal_lahir_istri" value="Tanggal Lahir" />
                                        <x-text-input id="tanggal_lahir_istri" name="tanggal_lahir_istri" type="text" class="mt-1 block w-full date-picker" :value="old('tanggal_lahir_istri')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="pendidikan_terakhir_istri" value="Pendidikan Terakhir" />
                                        <x-text-input id="pendidikan_terakhir_istri" name="pendidikan_terakhir_istri" type="text" class="mt-1 block w-full" :value="old('pendidikan_terakhir_istri')" placeholder="Contoh: S1, SMA" />
                                    </div>
                                    <div>
                                        <x-input-label for="nama_ayah_istri" value="Nama Ayah" />
                                        <x-text-input id="nama_ayah_istri" name="nama_ayah_istri" type="text" class="mt-1 block w-full" :value="old('nama_ayah_istri')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Alamat & Dokumen --}}
                        <div class="p-6 bg-gray-50 dark:bg-gray-900/50 rounded-xl ring-1 ring-gray-200 dark:ring-gray-700">
                            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-600 pb-4 mb-6">Alamat & Dokumen</h3>
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="alamat_pasangan" value="Alamat Pasangan" />
                                    <textarea id="alamat_pasangan" name="alamat_pasangan" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" rows="3" required>{{ old('alamat_pasangan') }}</textarea>
                                </div>
                                <div>
                                     <x-input-label for="desa" value="Desa" />
                                    <x-text-input id="desa" name="desa" type="text" class="mt-1 block w-full" :value="old('desa')" required />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                                    {{-- Upload File --}}
                                    <!-- <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="files">Upload File (Maks: 4)</label>
                                        <label for="files" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span> atau seret file</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF, DOC, DOCX (MAX. 2MB)</p>
                                            </div>
                                            <input id="files" name="files[]" type="file" class="hidden" multiple />
                                        </label>
                                    </div> -->
                                     {{-- Upload Gambar --}}
                                  <div class="pt-2">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="images">Upload Gambar (Maks: 5)</label>
                                        <label for="images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span> atau seret gambar</p>
                                                {{-- PERUBAHAN DI SINI --}}
                                                <p class="text-xs text-center text-gray-500 dark:text-gray-400">
                                                    Upload: Foto KTP, Foto KK, Foto Akta Kelahiran, Foto Calon Pengantin. (MAX. 2MB)
                                                </p>
                                            </div>
                                            <input id="images" name="images[]" type="file" class="hidden" multiple accept="image/*" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end gap-4 pt-4">
                            <a href="{{ route('petugas-kua.pernikahan.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <x-primary-button>{{ __('Simpan Data') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Flatpickr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Mengubah semua input dengan class 'date-picker' menjadi pemilih tanggal
        flatpickr(".date-picker", {
            dateFormat: "d/m/Y",
            allowInput: true, // Memungkinkan input manual
        });
    </script>
</x-app-layout>