<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Data Pernikahan Baru
        </h2>
    </x-slot>

    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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

                    <form method="POST" action="{{ route('petugas-kua.pernikahan.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="tanggal_akad" :value="__('Tanggal Akad')" />
                            <x-text-input id="tanggal_akad" name="tanggal_akad" type="date" class="mt-1 block w-full" :value="old('tanggal_akad')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_akad')" />
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
                        <div class="mt-4">
                            <x-input-label for="tempat_lahir_suami" :value="__('Tempat Lahir Suami')" />
                            <x-text-input id="tempat_lahir_suami" name="tempat_lahir_suami" type="text" class="mt-1 block w-full" :value="old('tempat_lahir_suami')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir_suami')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="tanggal_lahir_suami" :value="__('Tanggal Lahir Suami')" />
                            <x-text-input id="tanggal_lahir_suami" name="tanggal_lahir_suami" type="date" class="mt-1 block w-full" :value="old('tanggal_lahir_suami')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir_suami')" />
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
                        <div class="mt-4">
                            <x-input-label for="tempat_lahir_istri" :value="__('Tempat Lahir Istri')" />
                            <x-text-input id="tempat_lahir_istri" name="tempat_lahir_istri" type="text" class="mt-1 block w-full" :value="old('tempat_lahir_istri')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir_istri')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="tanggal_lahir_istri" :value="__('Tanggal Lahir Istri')" />
                            <x-text-input id="tanggal_lahir_istri" name="tanggal_lahir_istri" type="date" class="mt-1 block w-full" :value="old('tanggal_lahir_istri')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir_istri')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Flatpickr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#tanggal_akad", {
            dateFormat: "d/m/Y",
            defaultDate: "{{ old('tanggal_akad') }}"
        });

        flatpickr("#tanggal_lahir_suami", {
            dateFormat: "d/m/Y",
            defaultDate: "{{ old('tanggal_lahir_suami') }}"
        });

        flatpickr("#tanggal_lahir_istri", {
            dateFormat: "d/m/Y",
            defaultDate: "{{ old('tanggal_lahir_istri') }}"
        });
    </script>
</x-app-layout>
