<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Data Pernikahan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Panel Informasi Utama --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    {{-- Header Panel --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                                No. Akta: {{ $pernikahan->no_akta }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Dicatat di KUA: {{ $pernikahan->kua->nama_kua ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="mt-3 sm:mt-0">
                             <span @class([
                                'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
                                'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' => $pernikahan->status_verifikasi == 'disetujui',
                                'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' => $pernikahan->status_verifikasi == 'ditolak',
                                'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' => $pernikahan->status_verifikasi == 'menunggu',
                            ])>
                                {{ ucfirst($pernikahan->status_verifikasi) }}
                            </span>
                        </div>
                    </div>

                    {{-- Detail Administrasi & Wali --}}
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm">
                        <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Tanggal Daftar</dt>
                            <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($pernikahan->tanggal_daftar)->isoFormat('dddd, D MMMM Y') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Tanggal Akad</dt>
                            <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($pernikahan->tanggal_akad)->isoFormat('dddd, D MMMM Y') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Lokasi Akad</dt>
                            <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $pernikahan->tempat_akad }}</dd>
                        </div>
                         <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Jenis Wali</dt>
                            <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $pernikahan->wali }}</dd>
                        </div>
                         <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400">Nama Wali</dt>
                            <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $pernikahan->nama_wali }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel Data Pasangan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Data Suami --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">Data Suami</h4>
                        <dl class="space-y-4 text-sm">
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="font-medium text-gray-500 dark:text-gray-400 col-span-1">Nama</dt>
                                <dd class="text-gray-900 dark:text-white col-span-2 font-semibold">{{ $pernikahan->nama_suami }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="font-medium text-gray-500 dark:text-gray-400 col-span-1">NIK</dt>
                                <dd class="text-gray-900 dark:text-white col-span-2">{{ $pernikahan->nik_suami }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="font-medium text-gray-500 dark:text-gray-400 col-span-1">Tempat, Tgl Lahir</dt>
                                <dd class="text-gray-900 dark:text-white col-span-2">{{ $pernikahan->tempat_lahir_suami }}, {{ \Carbon\Carbon::parse($pernikahan->tanggal_lahir_suami)->isoFormat('D MMMM Y') }}</dd>
                            </div>
                             <div class="grid grid-cols-3 gap-4">
                                <dt class="font-medium text-gray-500 dark:text-gray-400 col-span-1">Usia Saat Akad</dt>
                                <dd class="text-gray-900 dark:text-white col-span-2">{{ $pernikahan->usia_suami }} Tahun</dd>
                            </div>
                             <div class="grid grid-cols-3 gap-4">
                                <dt class="font-medium text-gray-500 dark:text-gray-400 col-span-1">Nama Ayah</dt>
                                <dd class="text-gray-900 dark:text-white col-span-2">{{ $pernikahan->nama_ayah_suami ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Data Istri --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                     <div class="p-6">
                        <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">Data Istri</h4>
                        <dl class="space-y-4 text-sm">
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="font-medium text-gray-500 dark:text-gray-400 col-span-1">Nama</dt>
                                <dd class="text-gray-900 dark:text-white col-span-2 font-semibold">{{ $pernikahan->nama_istri }}</dd>
                            </div>
                             <div class="grid grid-cols-3 gap-4">
                                <dt class="font-medium text-gray-500 dark:text-gray-400 col-span-1">NIK</dt>
                                <dd class="text-gray-900 dark:text-white col-span-2">{{ $pernikahan->nik_istri }}</dd>
                            </div>
                             <div class="grid grid-cols-3 gap-4">
                                <dt class="font-medium text-gray-500 dark:text-gray-400 col-span-1">Tempat, Tgl Lahir</dt>
                                <dd class="text-gray-900 dark:text-white col-span-2">{{ $pernikahan->tempat_lahir_istri }}, {{ \Carbon\Carbon::parse($pernikahan->tanggal_lahir_istri)->isoFormat('D MMMM Y') }}</dd>
                            </div>
                             <div class="grid grid-cols-3 gap-4">
                                <dt class="font-medium text-gray-500 dark:text-gray-400 col-span-1">Usia Saat Akad</dt>
                                <dd class="text-gray-900 dark:text-white col-span-2">{{ $pernikahan->usia_istri }} Tahun</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="font-medium text-gray-500 dark:text-gray-400 col-span-1">Nama Ayah</dt>
                                <dd class="text-gray-900 dark:text-white col-span-2">{{ $pernikahan->nama_ayah_istri ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Panel Alamat, Dokumen, dan Gambar --}}
             <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                     <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                         {{-- Alamat --}}
                         <div class="space-y-4 text-sm">
                            <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Alamat & Lokasi</h4>
                            <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Alamat Pasangan</dt>
                                <dd class="mt-1 text-gray-900 dark:text-white">{{ $pernikahan->alamat_pasangan }}</dd>
                            </div>
                             <div>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Desa</dt>
                                <dd class="mt-1 text-gray-900 dark:text-white">{{ $pernikahan->desa }}</dd>
                            </div>
                         </div>
                         {{-- Dokumen & Gambar --}}
                         <div class="space-y-6">
                             @if($pernikahan->images->isNotEmpty())
                                <div>
                                    <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">Gambar Terlampir</h4>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                        @foreach($pernikahan->images as $image)
                                            <a href="{{ Storage::url($image->image_path) }}" target="_blank" class="group">
                                                <img src="{{ Storage::url($image->image_path) }}" alt="Gambar Pernikahan" class="w-full h-24 object-cover rounded-lg group-hover:opacity-80 transition-opacity">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                         </div>
                     </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end gap-4 mt-2">
                <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    Kembali
                </a>
                <a href="{{ route('petugas-kua.pernikahan.edit', $pernikahan->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Edit Data
                </a>
                 <form action="{{ route('petugas-kua.pernikahan.destroy', $pernikahan->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini secara permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>