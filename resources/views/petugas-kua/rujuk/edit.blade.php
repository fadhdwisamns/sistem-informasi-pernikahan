<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Rujuk') }}
        </h2>
    </x-slot>

    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
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

                    <form method="POST" action="{{ route('petugas-kua.rujuk.update', $rujuk) }}" class="space-y-6">
                        @csrf
                        @method('PUT') {{-- Penting: Gunakan method PUT/PATCH untuk update --}}

                        {{-- Field No Surat Rujuk (Read-only karena auto-generate) --}}
                        <div>
                            <x-input-label for="no_surat_rujuk" :value="__('Nomor Surat Rujuk')" />
                            {{-- Tampilkan sebagai teks biasa atau input readonly --}}
                            <p class="mt-1 p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                {{ $rujuk->no_surat_rujuk }}
                            </p>
                            {{-- Jika Anda ingin input readonly, gunakan ini:
                            <x-text-input id="no_surat_rujuk" name="no_surat_rujuk" type="text" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 cursor-not-allowed" :value="$rujuk->no_surat_rujuk" readonly />
                            --}}
                        </div>

                        {{-- Input Tanggal Rujuk --}}
                        <div>
                            <x-input-label for="tanggal_rujuk" :value="__('Tanggal Rujuk')" />
                            <x-text-input id="tanggal_rujuk" name="tanggal_rujuk" type="text" class="mt-1 block w-full" :value="old('tanggal_rujuk', $rujuk->tanggal_rujuk)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_rujuk')" />
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">Data Suami</h3>
                        <div>
                            <x-input-label for="nama_suami" :value="__('Nama Suami')" />
                            <x-text-input id="nama_suami" name="nama_suami" type="text" class="mt-1 block w-full" :value="old('nama_suami', $rujuk->nama_suami)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_suami')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="nik_suami" :value="__('NIK Suami')" />
                            <x-text-input id="nik_suami" name="nik_suami" type="text" class="mt-1 block w-full" :value="old('nik_suami', $rujuk->nik_suami)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nik_suami')" />
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">Data Istri</h3>
                        <div>
                            <x-input-label for="nama_istri" :value="__('Nama Istri')" />
                            <x-text-input id="nama_istri" name="nama_istri" type="text" class="mt-1 block w-full" :value="old('nama_istri', $rujuk->nama_istri)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_istri')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="nik_istri" :value="__('NIK Istri')" />
                            <x-text-input id="nik_istri" name="nik_istri" type="text" class="mt-1 block w-full" :value="old('nik_istri', $rujuk->nik_istri)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nik_istri')" />
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        {{-- Input Tempat Rujuk --}}
                        <div>
                            <x-input-label for="tempat_rujuk" :value="__('Tempat Rujuk')" />
                            <x-text-input id="tempat_rujuk" name="tempat_rujuk" type="text" class="mt-1 block w-full" :value="old('tempat_rujuk', $rujuk->tempat_rujuk)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tempat_rujuk')" />
                        </div>

                        {{-- Input Status --}}
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="Menunggu" {{ old('status', $rujuk->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Disetujui" {{ old('status', $rujuk->status) == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="Ditolak" {{ old('status', $rujuk->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>


                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('petugas-kua.rujuk.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Data Rujuk') }}
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
            defaultDate: "{{ old('tanggal_rujuk', $rujuk->tanggal_rujuk) }}"
        });
    </script>
</x-app-layout>