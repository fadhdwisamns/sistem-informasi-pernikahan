<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Verifikasi Data Perceraian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

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

                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-6">Detail Perceraian untuk Verifikasi</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div><p class="font-medium text-gray-500 dark:text-gray-400">Pengadilan Agama:</p><p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->masterPa->nama_pa }}</p></div>
                        <div><p class="font-medium text-gray-500 dark:text-gray-400">Tanggal Putusan:</p><p class="text-gray-900 dark:text-gray-100 mt-1">{{ \Carbon\Carbon::parse($perceraian->tanggal_putusan)->translatedFormat('d F Y') }}</p></div>
                        <div><p class="font-medium text-gray-500 dark:text-gray-400">Penggugat:</p><p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->nama_penggugat }} (NIK: {{ $perceraian->nik_penggugat }})</p></div>
                        <div><p class="font-medium text-gray-500 dark:text-gray-400">Tergugat:</p><p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->nama_tergugat }} (NIK: {{ $perceraian->nik_tergugat }})</p></div>
                        <div class="md:col-span-2"><p class="font-medium text-gray-500 dark:text-gray-400">Dibuat Oleh:</p><p class="text-gray-900 dark:text-gray-100 mt-1">{{ $perceraian->createdBy->name ?? 'N/A' }}</p></div>
                    </div>

                    <form method="POST" action="{{ route('admin.perceraians.verify_data', $perceraian) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- Status Verifikasi --}}
                        <div>
                            <x-input-label for="status_verifikasi" :value="__('Status Verifikasi')" />
                            <select id="status_verifikasi" name="status_verifikasi" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="menunggu" {{ old('status_verifikasi', $perceraian->status_verifikasi) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="disetujui" {{ old('status_verifikasi', $perceraian->status_verifikasi) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ old('status_verifikasi', $perceraian->status_verifikasi) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status_verifikasi')" />
                        </div>

                        {{-- Catatan Verifikasi --}}
                        <div>
                            <x-input-label for="catatan_verifikasi" :value="__('Catatan Verifikasi (Opsional)')" />
                            <textarea id="catatan_verifikasi" name="catatan_verifikasi" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('catatan_verifikasi', $perceraian->catatan_verifikasi) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('catatan_verifikasi')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('admin.verification.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Verifikasi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>