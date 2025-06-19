<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Data Pernikahan
        </h2>
    </x-slot>

    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 text-gray-900 dark:text-gray-100">

                    @if ($errors->any() || session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/50 text-red-700 dark:text-red-300 border border-red-300 dark:border-red-600 rounded-lg shadow-md flex items-start">
                <div class="flex-shrink-0">
                    {{-- Ikon Peringatan --}}
                    <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <strong class="font-bold">Oops! Terjadi kesalahan.</strong>

                    {{-- Cek jika ada error dari session --}}
                    @if(session('error'))
                        <p class="text-sm mt-1">{{ session('error') }}</p>
                    @else
                    {{-- Jika tidak, tampilkan error validasi --}}
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endif
                    {{-- Formulir Edit Data Pernikahan --}}

                    <form method="POST" action="{{ route('petugas-kua.pernikahan.update', $pernikahan->id) }}" class="space-y-8" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH') {{-- Menggunakan method PATCH untuk update --}}

                        {{-- Panel Data Administrasi & Wali --}}
                        <div class="p-6 bg-gray-50 dark:bg-gray-900/50 rounded-xl ring-1 ring-gray-200 dark:ring-gray-700">
                            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-600 pb-4 mb-6">Data Administrasi & Wali</h3>
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <x-input-label for="tanggal_daftar" value="Tanggal Daftar" />
                                        <x-text-input id="tanggal_daftar" name="tanggal_daftar" type="text" class="mt-1 block w-full date-picker" :value="old('tanggal_daftar', \Carbon\Carbon::parse($pernikahan->tanggal_daftar)->format('d/m/Y'))" required />
                                    </div>
                                    <div>
                                        <x-input-label for="tanggal_akad" value="Tanggal Akad" />
                                        <x-text-input id="tanggal_akad" name="tanggal_akad" type="text" class="mt-1 block w-full date-picker" :value="old('tanggal_akad', \Carbon\Carbon::parse($pernikahan->tanggal_akad)->format('d/m/Y'))" required />
                                    </div>
                                    <div>
                                        <x-input-label for="tempat_akad" value="Lokasi Akad" />
                                        <x-text-input id="tempat_akad" name="tempat_akad" type="text" class="mt-1 block w-full" :value="old('tempat_akad', $pernikahan->tempat_akad)" required />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="wali" value="Jenis Wali" />
                                        <x-text-input id="wali" name="wali" type="text" class="mt-1 block w-full" :value="old('wali', $pernikahan->wali)" required placeholder="Contoh: Nasab, Hakim" />
                                    </div>
                                    <div>
                                        <x-input-label for="nama_wali" value="Nama Wali" />
                                        <x-text-input id="nama_wali" name="nama_wali" type="text" class="mt-1 block w-full" :value="old('nama_wali', $pernikahan->nama_wali)" required />
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
                                    <x-text-input id="nama_suami" name="nama_suami" type="text" class="mt-1 block w-full" :value="old('nama_suami', $pernikahan->nama_suami)" required />
                                </div>
                                <div>
                                    <x-input-label for="nik_suami" value="NIK Suami" />
                                    <x-text-input id="nik_suami" name="nik_suami" type="text" class="mt-1 block w-full" :value="old('nik_suami', $pernikahan->nik_suami)" required />
                                </div>
                                <div>
                                    <x-input-label for="tempat_lahir_suami" value="Tempat Lahir" />
                                    <x-text-input id="tempat_lahir_suami" name="tempat_lahir_suami" type="text" class="mt-1 block w-full" :value="old('tempat_lahir_suami', $pernikahan->tempat_lahir_suami)" required />
                                </div>
                                <div>
                                    <x-input-label for="tanggal_lahir_suami" value="Tanggal Lahir" />
                                    <x-text-input id="tanggal_lahir_suami" name="tanggal_lahir_suami" type="text" class="mt-1 block w-full date-picker" :value="old('tanggal_lahir_suami', \Carbon\Carbon::parse($pernikahan->tanggal_lahir_suami)->format('d/m/Y'))" required />
                                </div>
                            </div>

                            {{-- KOLOM KANAN: DATA ISTRI --}}
                            <div class="space-y-6">
                                <h4 class="font-semibold text-lg text-gray-700 dark:text-gray-300">Data Istri</h4>
                                <div>
                                    <x-input-label for="nama_istri" value="Nama Istri" />
                                    <x-text-input id="nama_istri" name="nama_istri" type="text" class="mt-1 block w-full" :value="old('nama_istri', $pernikahan->nama_istri)" required />
                                </div>
                                <div>
                                    <x-input-label for="nik_istri" value="NIK Istri" />
                                    <x-text-input id="nik_istri" name="nik_istri" type="text" class="mt-1 block w-full" :value="old('nik_istri', $pernikahan->nik_istri)" required />
                                </div>
                                <div>
                                    <x-input-label for="tempat_lahir_istri" value="Tempat Lahir" />
                                    <x-text-input id="tempat_lahir_istri" name="tempat_lahir_istri" type="text" class="mt-1 block w-full" :value="old('tempat_lahir_istri', $pernikahan->tempat_lahir_istri)" required />
                                </div>
                                <div>
                                    <x-input-label for="tanggal_lahir_istri" value="Tanggal Lahir" />
                                    <x-text-input id="tanggal_lahir_istri" name="tanggal_lahir_istri" type="text" class="mt-1 block w-full date-picker" :value="old('tanggal_lahir_istri', \Carbon\Carbon::parse($pernikahan->tanggal_lahir_istri)->format('d/m/Y'))" required />
                                </div>
                            </div>
                        </div>
                    </div>

                        {{-- Panel Usia Pasangan --}}
                        {{-- Panel Alamat & Dokumen --}}
                        <div class="p-6 bg-gray-50 dark:bg-gray-900/50 rounded-xl ring-1 ring-gray-200 dark:ring-gray-700">
                            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 border-b border-gray-300 dark:border-gray-600 pb-4 mb-6">Alamat & Dokumen</h3>
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="alamat_pasangan" value="Alamat Pasangan" />
                                    <textarea id="alamat_pasangan" name="alamat_pasangan" class="border-gray-300 ... rounded-md shadow-sm mt-1 block w-full" rows="3" required>{{ old('alamat_pasangan', $pernikahan->alamat_pasangan) }}</textarea>
                                </div>
                                <div>
                                     <x-input-label for="desa" value="Desa" />
                                    <x-text-input id="desa" name="desa" type="text" class="mt-1 block w-full" :value="old('desa', $pernikahan->desa)" required />
                                </div>

                                {{-- Menampilkan file yang sudah ada --}}
                                @if($pernikahan->files->isNotEmpty())
                                <div class="space-y-3">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Dokumen Terunggah (Centang untuk hapus)</label>
                                    @foreach($pernikahan->files as $file)
                                        <div class="flex items-center justify-between text-sm p-2 bg-gray-100 dark:bg-gray-800 rounded-md">
                                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-cyan-600 hover:underline truncate pr-4">{{ $file->original_name }}</a>
                                            <div class="flex items-center">
                                                <input type="checkbox" name="delete_files[]" value="{{ $file->id }}" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                <label class="ml-2 text-red-600">Hapus</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endif

                                {{-- Menampilkan gambar yang sudah ada --}}
                                @if($pernikahan->images->isNotEmpty())
                                <div class="space-y-3">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Gambar Terunggah (Centang untuk hapus)</label>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                        @foreach($pernikahan->images as $image)
                                            <div class="relative group">
                                                <img src="{{ Storage::url($image->image_path) }}" alt="Gambar Pernikahan" class="w-full h-32 object-cover rounded-lg">
                                                <div class="absolute top-1 right-1">
                                                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="h-5 w-5 rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                {{-- Input untuk menambah file & gambar baru --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="files">Tambah File Baru (Maks: 4)</label>
                                        <input id="files" name="files[]" type="file" class="... (sama seperti di create)" multiple>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="images">Tambah Gambar Baru (Maks: 4)</label>
                                        <input id="images" name="images[]" type="file" class="... (sama seperti di create)" multiple accept="image/*" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end gap-4 pt-4">
                            <a href="{{ url()->previous() }}" class="... (tombol Batal)">Batal</a>
                            <x-primary-button>{{ __('Update Data') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Flatpickr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr(".date-picker", {
            dateFormat: "d/m/Y",
            allowInput: true,
        });
    </script>
</x-app-layout>