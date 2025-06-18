<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Rujuk') }}
        </h2>
    </x-slot>

    <div class="py-12"> {{-- Increased vertical padding for more breathing room --}}
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8"> {{-- Increased max-width for wider tables --}}

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-md alert alert-success"> {{-- Added shadow-md and alert class for potential JS --}}
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6"> {{-- Used justify-between to space out elements --}}
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Data Rujuk</h3> {{-- Added a sub-heading --}}
                <a href="{{ route('petugas-kua.rujuk.create') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-black font-semibold rounded-lg shadow-md transition ease-in-out duration-150"> {{-- Improved button styling --}}
                   <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    {{ __('Tambah Data Rujuk') }}
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg"> {{-- Added shadow-xl for a more prominent card effect --}}
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg"> {{-- Added relative and shadow-md to table wrapper --}}
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400"> {{-- Changed min-w-full to w-full --}}
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"> {{-- Improved header styling --}}
                                <tr>
                                    <th scope="col" class="py-3 px-6">No</th> {{-- Used scope="col" for accessibility --}}
                                    <th scope="col" class="py-3 px-6">No Surat Rujuk</th>
                                    <th scope="col" class="py-3 px-6">Tanggal Rujuk</th>
                                    <th scope="col" class="py-3 px-6">Nama Suami</th>
                                    <th scope="col" class="py-3 px-6">Nama Istri</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                    <th scope="col" class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700"> {{-- Added divider between rows --}}
                                @forelse ($rujuks as $rujuk)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"> {{-- Hover effect for rows --}}
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">{{ $loop->iteration }}</td> {{-- Added whitespace-nowrap --}}
                                        <td class="py-4 px-6">{{ $rujuk->no_surat_rujuk }}</td>
                                        <td class="py-4 px-6">{{ $rujuk->tanggal_rujuk }}</td>
                                        <td class="py-4 px-6">{{ $rujuk->nama_suami }}</td>
                                        <td class="py-4 px-6">{{ $rujuk->nama_istri }}</td>
                                        <td class="py-4 px-6">
                                            @if($rujuk->status == 'Disetujui')
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $rujuk->status }}
                                                </span>
                                            @elseif($rujuk->status == 'Ditolak')
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ $rujuk->status }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $rujuk->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center whitespace-nowrap">
                                            {{-- Detail Button (Icon) --}}
                                            <a href="{{ route('petugas-kua.rujuk.show', $rujuk) }}"
                                               title="Detail"
                                               class="inline-flex items-center p-2 text-blue-600 dark:text-blue-500 hover:text-blue-800 dark:hover:text-blue-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>

                                            {{-- Edit Button (Icon) --}}
                                            <a href="{{ route('petugas-kua.rujuk.edit', $rujuk) }}"
                                               title="Edit"
                                               class="inline-flex items-center p-2 text-yellow-600 dark:text-yellow-500 hover:text-yellow-800 dark:hover:text-yellow-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>

                                            {{-- Delete Button (Icon with Form) --}}
                                            <form id="delete-form-{{ $rujuk->id }}" action="{{ route('petugas-kua.rujuk.destroy', $rujuk) }}"
                                                method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" {{-- Ubah type="submit" menjadi type="button" --}}
                                                        title="Hapus"
                                                        class="inline-flex items-center p-2 text-red-600 dark:text-red-500 hover:text-red-800 dark:hover:text-red-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out"
                                                        onclick="confirmDelete({{ $rujuk->id }})"> {{-- Tambahkan onclick event --}}
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 px-6 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada data rujuk yang ditemukan.
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
    @push('scripts') {{-- Jika Anda menggunakan @push('scripts') dan @stack('scripts') di app.blade.php --}}
<script>
    function confirmDelete(rujukId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data rujuk ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626', // Warna merah untuk tombol Ya
            cancelButtonColor: '#6b7280', // Warna abu-abu untuk tombol Batal
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + rujukId).submit();
            }
        });
    }
</script>
@endpush
</x-app-layout>