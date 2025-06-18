<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Perceraian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-md alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Data Perceraian</h3>
                {{-- Link Tambah Data Perceraian - Gunakan $routePrefix --}}
                <a href="{{ route($routePrefix . '.perceraians.create') }}" {{-- UBAH INI: $userRolePrefix menjadi $routePrefix --}}
                   class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-black font-semibold rounded-lg shadow-md transition ease-in-out duration-150">
                   <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    {{ __('Tambah Data Perceraian') }}
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">No</th>
                                    <th scope="col" class="py-3 px-6">No Putusan</th>
                                    <th scope="col" class="py-3 px-6">Nama Penggugat</th>
                                    <th scope="col" class="py-3 px-6">Nama Tergugat</th>
                                    <th scope="col" class="py-3 px-6">Tanggal Putusan</th>
                                    <th scope="col" class="py-3 px-6">Status Verifikasi</th>
                                    <th scope="col" class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($perceraians as $perceraian)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">{{ $loop->iteration }}</td>
                                        <td class="py-4 px-6">{{ $perceraian->no_putusan }}</td>
                                        <td class="py-4 px-6">{{ $perceraian->nama_penggugat }}</td>
                                        <td class="py-4 px-6">{{ $perceraian->nama_tergugat }}</td>
                                        <td class="py-4 px-6">{{ \Carbon\Carbon::parse($perceraian->tanggal_putusan)->translatedFormat('d F Y') }}</td>
                                        <td class="py-4 px-6">
                                            @php
                                                $statusClass = [
                                                    'menunggu' => 'bg-yellow-100 text-yellow-800',
                                                    'disetujui' => 'bg-green-100 text-green-800',
                                                    'ditolak' => 'bg-red-100 text-red-800',
                                                ][$perceraian->status_verifikasi] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                {{ ucfirst($perceraian->status_verifikasi) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center whitespace-nowrap">
                                            {{-- Detail Button (Icon) - Gunakan $routePrefix --}}
                                            <a href="{{ route($routePrefix . '.perceraians.show', $perceraian) }}" {{-- UBAH INI --}}
                                               title="Detail"
                                               class="inline-flex items-center p-2 text-blue-600 dark:text-blue-500 hover:text-blue-800 dark:hover:text-blue-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>

                                            {{-- Edit Button (Icon) - Gunakan $routePrefix --}}
                                            <a href="{{ route($routePrefix . '.perceraians.edit', $perceraian) }}" {{-- UBAH INI --}}
                                               title="Edit"
                                               class="inline-flex items-center p-2 text-yellow-600 dark:text-yellow-500 hover:text-yellow-800 dark:hover:text-yellow-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            {{-- Delete Button (Icon with SweetAlert2) - Gunakan $routePrefix --}}
                                            <form id="delete-form-{{ $perceraian->id }}" action="{{ route($routePrefix . '.perceraians.destroy', $perceraian) }}" {{-- UBAH INI --}}
                                                  method="POST"
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        title="Hapus"
                                                        class="inline-flex items-center p-2 text-red-600 dark:text-red-500 hover:text-red-800 dark:hover:text-red-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out"
                                                        onclick="confirmDelete({{ $perceraian->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 px-6 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada data perceraian yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(perceraianId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data perceraian ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + perceraianId).submit();
                }
            });
        }
    </script>
    @endpush
</x-app-layout>