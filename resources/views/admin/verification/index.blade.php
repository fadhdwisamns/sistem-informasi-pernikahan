<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 dark:text-white leading-tight">
            {{ __('Dashboard Verifikasi Data') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg p-6 space-y-10">

                <div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">📋 Data Menunggu Verifikasi</h3>

                    {{-- Pernikahan --}}
                    <section>
                        <h4 class="text-lg font-semibold text-blue-700 dark:text-blue-400 mb-3">💍 Pernikahan</h4>
                        @if($pendingPernikahans->isNotEmpty())
                            <div class="overflow-x-auto rounded-lg shadow border border-gray-200 dark:border-gray-700">
                                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                                    <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                        <tr>
                                            <th class="px-4 py-3">No</th>
                                            <th class="px-4 py-3">No Akta Nikah</th>
                                            <th class="px-4 py-3">Suami</th>
                                            <th class="px-4 py-3">Istri</th>
                                            <th class="px-4 py-3">Status</th>
                                            <th class="px-4 py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-900">
                                        @foreach($pendingPernikahans as $pernikahan)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 border-b dark:border-gray-700">
                                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-3">{{ $pernikahan->no_akta_nikah }}</td>
                                                <td class="px-4 py-3">{{ $pernikahan->nama_suami }}</td>
                                                <td class="px-4 py-3">{{ $pernikahan->nama_istri }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                                        {{ $pernikahan->status === 'menunggu' ? 'bg-yellow-200 text-yellow-800' :
                                                           ($pernikahan->status === 'disetujui' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') }}">
                                                        {{ ucfirst($pernikahan->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <a href="{{ route('admin.pernikahan.show_verify_form', $pernikahan) }}"
                                                       class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                       Verifikasi
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">Tidak ada data pernikahan yang menunggu verifikasi.</p>
                        @endif
                    </section>

                    <hr class="my-8 border-t dark:border-gray-600">

                    {{-- Rujuk --}}
                    <section>
                        <h4 class="text-lg font-semibold text-purple-700 dark:text-purple-400 mb-3">🔁 Rujuk</h4>
                        @if($pendingRujuks->isNotEmpty())
                            <div class="overflow-x-auto rounded-lg shadow border border-gray-200 dark:border-gray-700">
                                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                                    <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                        <tr>
                                            <th class="px-4 py-3">No</th>
                                            <th class="px-4 py-3">No Surat Rujuk</th>
                                            <th class="px-4 py-3">Suami</th>
                                            <th class="px-4 py-3">Istri</th>
                                            <th class="px-4 py-3">Status</th>
                                            <th class="px-4 py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-900">
                                        @foreach($pendingRujuks as $rujuk)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 border-b dark:border-gray-700">
                                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-3">{{ $rujuk->no_surat_rujuk }}</td>
                                                <td class="px-4 py-3">{{ $rujuk->nama_suami }}</td>
                                                <td class="px-4 py-3">{{ $rujuk->nama_istri }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                                        {{ $rujuk->status === 'Menunggu' ? 'bg-yellow-200 text-yellow-800' :
                                                           ($rujuk->status === 'Disetujui' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') }}">
                                                        {{ $rujuk->status }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <a href="{{ route('admin.rujuk.show_verify_form', $rujuk) }}"
                                                       class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                       Verifikasi
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">Tidak ada data rujuk yang menunggu verifikasi.</p>
                        @endif
                    </section>

                    <hr class="my-8 border-t dark:border-gray-600">

                    {{-- Perceraian --}}
                    <section>
                        <h4 class="text-lg font-semibold text-red-700 dark:text-red-400 mb-3">⚖️ Perceraian</h4>
                        @if($pendingPerceraians->isNotEmpty())
                            <div class="overflow-x-auto rounded-lg shadow border border-gray-200 dark:border-gray-700">
                                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                                    <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                        <tr>
                                            <th class="px-4 py-3">No</th>
                                            <th class="px-4 py-3">No Putusan</th>
                                            <th class="px-4 py-3">Penggugat</th>
                                            <th class="px-4 py-3">Tergugat</th>
                                            <th class="px-4 py-3">Status</th>
                                            <th class="px-4 py-3">Dibuat Oleh</th>
                                            <th class="px-4 py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-900">
                                        @foreach($pendingPerceraians as $perceraian)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 border-b dark:border-gray-700">
                                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-3">{{ $perceraian->no_putusan }}</td>
                                                <td class="px-4 py-3">{{ $perceraian->nama_penggugat }}</td>
                                                <td class="px-4 py-3">{{ $perceraian->nama_tergugat }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                                        {{ $perceraian->status_verifikasi === 'menunggu' ? 'bg-yellow-200 text-yellow-800' :
                                                           ($perceraian->status_verifikasi === 'disetujui' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') }}">
                                                        {{ ucfirst($perceraian->status_verifikasi) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">{{ $perceraian->createdBy->name ?? 'N/A' }}</td>
                                                <td class="px-4 py-3">
                                                    <a href="{{ route('admin.perceraians.show_verify_form', $perceraian) }}"
                                                       class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                       Verifikasi
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">Tidak ada data perceraian yang menunggu verifikasi.</p>
                        @endif
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
