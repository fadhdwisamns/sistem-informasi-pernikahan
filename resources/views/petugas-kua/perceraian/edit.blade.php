<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Data Perceraian') }}
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

                    <form method="POST" action="{{ route($routePrefix . '.perceraians.update', $perceraian) }}" class="space-y-6">
                        @csrf
                        @method('PUT') {{-- PENTING: Gunakan method PUT/PATCH untuk update --}}

                        {{-- Field No Putusan (Read-only karena auto-generate) --}}
                        <div>
                            <x-input-label for="no_putusan" :value="__('Nomor Putusan')" />
                            <p class="mt-1 p-2 border border-gray-300 dark:border-gray-700 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                {{ $perceraian->no_putusan }}
                            </p>
                            {{-- Jika Anda ingin input readonly, bisa pakai:
                            <x-text-input id="no_putusan" name="no_putusan" type="text" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 cursor-not-allowed" :value="$perceraian->no_putusan" readonly />
                            --}}
                        </div>

                        {{-- Dropdown Pilih Pengadilan Agama --}}
                        <div>
                            <x-input-label for="pa_id" :value="__('Pilih Pengadilan Agama')" />
                            <select id="pa_id" name="pa_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="">-- Pilih PA --</option>
                                @foreach($masterPas as $pa)
                                    <option value="{{ $pa->id }}" {{ old('pa_id', $perceraian->pa_id) == $pa->id ? 'selected' : '' }}>
                                        {{ $pa->nama_pa }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('pa_id')" />
                        </div>

                        <div>
                            <x-input-label for="kua_id" :value="__('Pilih KUA Terkait')" />
                            <select id="kua_id" name="kua_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="">-- Pilih KUA --</option>
                                @foreach($masterKuas as $kua)
                                    <option value="{{ $kua->id }}" {{ old('kua_id', $perceraian->kua_id) == $kua->id ? 'selected' : '' }}>
                                        {{ $kua->nama_kua }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('kua_id')" />
                        </div>

                        {{-- Input Tanggal Putusan --}}
                        <div>
                            <x-input-label for="tanggal_putusan" :value="__('Tanggal Putusan')" />
                            <x-text-input id="tanggal_putusan" name="tanggal_putusan" type="text" class="mt-1 block w-full" :value="old('tanggal_putusan', $perceraian->tanggal_putusan)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_putusan')" />
                        </div>

                        <div>
                            <x-input-label for="jenis_cerai" :value="__('Jenis Cerai')" />
                            <select id="jenis_cerai" name="jenis_cerai" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Jenis Cerai --</option>
                                <option value="talak" {{ old('jenis_cerai', $perceraian->jenis_cerai) == 'talak' ? 'selected' : '' }}>Cerai Talak</option>
                                <option value="gugat" {{ old('jenis_cerai', $perceraian->jenis_cerai) == 'gugat' ? 'selected' : '' }}>Cerai Gugat</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_cerai')" />
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">Data Pihak</h3>
                        <div>
                            <x-input-label for="nama_penggugat" :value="__('Nama Penggugat')" />
                            <x-text-input id="nama_penggugat" name="nama_penggugat" type="text" class="mt-1 block w-full" :value="old('nama_penggugat', $perceraian->nama_penggugat)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_penggugat')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="nik_penggugat" :value="__('NIK Penggugat')" />
                            <x-text-input id="nik_penggugat" name="nik_penggugat" type="text" class="mt-1 block w-full" :value="old('nik_penggugat', $perceraian->nik_penggugat)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nik_penggugat')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="nama_tergugat" :value="__('Nama Tergugat')" />
                            <x-text-input id="nama_tergugat" name="nama_tergugat" type="text" class="mt-1 block w-full" :value="old('nama_tergugat', $perceraian->nama_tergugat)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_tergugat')" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="nik_tergugat" :value="__('NIK Tergugat')" />
                            <x-text-input id="nik_tergugat" name="nik_tergugat" type="text" class="mt-1 block w-full" :value="old('nik_tergugat', $perceraian->nik_tergugat)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nik_tergugat')" />
                        </div>
                        
                        <div>
                            <x-input-label for="tempat_cerai" :value="__('Tempat Sidang Cerai')" />
                            <x-text-input id="tempat_cerai" name="tempat_cerai" type="text" class="mt-1 block w-full" :value="old('tempat_cerai', $perceraian->tempat_cerai)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tempat_cerai')" />
                        </div>

                        <div>
                            <x-input-label for="penyebab_cerai" :value="__('Penyebab Cerai (Opsional)')" />
                            <textarea id="penyebab_cerai" name="penyebab_cerai" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('penyebab_cerai', $perceraian->penyebab_cerai) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('penyebab_cerai')" />
                        </div>

                        {{-- Input Status Verifikasi --}}
                        <div>
                            <x-input-label for="status_verifikasi" :value="__('Status Verifikasi')" />
                            <select id="status_verifikasi" name="status_verifikasi" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="menunggu" {{ old('status_verifikasi', $perceraian->status_verifikasi) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="disetujui" {{ old('status_verifikasi', $perceraian->status_verifikasi) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ old('status_verifikasi', $perceraian->status_verifikasi) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status_verifikasi')" />
                        </div>

                        {{-- Catatan Verifikasi (opsional, mungkin hanya muncul jika status ditolak/disetujui) --}}
                        <div>
                            <x-input-label for="catatan_verifikasi" :value="__('Catatan Verifikasi (Opsional)')" />
                            <textarea id="catatan_verifikasi" name="catatan_verifikasi" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('catatan_verifikasi', $perceraian->catatan_verifikasi) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('catatan_verifikasi')" />
                        </div>


                        <div class="flex items-center justify-end gap-4 mt-6">
                            {{-- Tombol Batal --}}
                            <a href="{{ route($routePrefix . '.perceraians.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>
                            {{-- Tombol Update --}}
                            <x-primary-button>
                                {{ __('Update Data Perceraian') }}
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
        flatpickr("#tanggal_putusan", {
            dateFormat: "Y-m-d", // Format sesuai dengan yang biasa digunakan di database (YYYY-MM-DD)
            defaultDate: "{{ old('tanggal_putusan', $perceraian->tanggal_putusan) }}"
        });
    </script>
</x-app-layout>