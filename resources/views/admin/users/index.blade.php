<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Akun') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-md">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Daftar Akun Pengguna</h3>
                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-black font-semibold rounded-md shadow transition">
                   <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                   </svg>
                   {{ __('Tambah Akun') }}
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                            <thead class="text-xs text-white uppercase bg-gray-600 dark:bg-gray-700 sticky top-0 z-10">
                                <tr>
                                    <th scope="col" class="py-3 px-6">No</th>
                                    <th scope="col" class="py-3 px-6">Nama</th>
                                    <th scope="col" class="py-3 px-6">Username</th>
                                    <th scope="col" class="py-3 px-6">Role</th>
                                    <th scope="col" class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($users as $user)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="py-4 px-6 text-center font-medium">{{ $loop->iteration }}</td>
                                        <td class="py-4 px-6">{{ $user->name }}</td>
                                        <td class="py-4 px-6">{{ $user->username }}</td>
                                        <td class="py-4 px-6">{{ ucfirst($user->role) }}</td>
                                        <td class="py-4 px-6 text-center whitespace-nowrap">
                                            {{-- Edit Button --}}
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               title="Edit"
                                               class="inline-flex items-center p-2 text-yellow-600 hover:text-yellow-800 rounded-full hover:bg-yellow-100 dark:hover:bg-gray-700 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>

                                            {{-- Delete Button --}}
                                            <form id="delete-user-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}"
                                                  method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        title="Hapus"
                                                        class="inline-flex items-center p-2 text-red-600 hover:text-red-800 rounded-full hover:bg-red-100 dark:hover:bg-gray-700 transition"
                                                        onclick="confirmUserDelete({{ $user->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-6 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada akun pengguna ditemukan.
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
        function confirmUserDelete(userId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Akun pengguna ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '',
                color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-user-form-' + userId).submit();
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
