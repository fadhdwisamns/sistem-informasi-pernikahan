<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Data Perceraian Baru') }}
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

                    <form method="POST" action="{{ route('petugas-kua.perceraians.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="pa_id" :value="__('Pilih Pengadilan Agama')" />
                            <select id="pa_id" name="pa_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="">-- Pilih PA --</option>
                                @foreach($masterPas as $pa)
                                    <option value="{{ $pa->id }}" {{ old('pa_id') == $pa->id ? 'selected' : '' }}>
                                        {{ $pa->nama_pa }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('pa_id')" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_putusan" :value="__('Tanggal Putusan')" />
                            <x-text-input id="tanggal_putusan" name="tanggal_putusan" type="text" class="mt-1 block w-full" :value="old('tanggal_putusan')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_putusan')" />
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">Data Pihak</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Isi informasi detail mengenai pihak penggugat dan tergugat.</p>

                        <div>
                            <x-input-label for="nama_penggugat" :value="__('Nama Penggugat')" />
                            <x-text-input id="nama_penggugat" name="nama_penggugat" type="text" class="mt-1 block w-full" :value="old('nama_penggugat')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_penggugat')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="nama_tergugat" :value="__('Nama Tergugat')" />
                            <x-text-input id="nama_tergugat" name="nama_tergugat" type="text" class="mt-1 block w-full" :value="old('nama_tergugat')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_tergugat')" />
                        </div>
                        
                        <div>
                            <x-input-label for="tempat_cerai" :value="__('Tempat Sidang Cerai')" />
                            <x-text-input id="tempat_cerai" name="tempat_cerai" type="text" class="mt-1 block w-full" :value="old('tempat_cerai')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tempat_cerai')" />
                        </div>

                        <div>
                            <x-input-label for="penyebab_cerai" :value="__('Penyebab Cerai (Opsional)')" />
                            <textarea id="penyebab_cerai" name="penyebab_cerai" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('penyebab_cerai') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('penyebab_cerai')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('petugas-kua.perceraians.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Data Perceraian') }}
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
        flatpickr("#tanggal_putusan", { // Changed to tanggal_putusan
            dateFormat: "Y-m-d",
            defaultDate: "{{ old('tanggal_putusan') ? old('tanggal_putusan') : date('Y-m-d') }}"
        });
    </script>
</x-app-layout>