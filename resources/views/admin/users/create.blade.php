<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Akun Pengguna Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
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

                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                        @csrf

                        {{-- Nama --}}
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        {{-- Username --}}
                        <div>
                            <x-input-label for="username" :value="__('Username')" />
                            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('username')" />
                        </div>

                        {{-- Password --}}
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>

                        {{-- Role --}}
                        <div>
                            <x-input-label for="role" :value="__('Role Pengguna')" />
                            <select id="role" name="role" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach($roles as $roleOption)
                                    <option value="{{ $roleOption }}" {{ old('role') == $roleOption ? 'selected' : '' }}>
                                        {{ ucfirst($roleOption) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>
                        
                        {{-- Master KUA (Dropdown baru) --}}
                        <div id="master-kua-field" style="display: {{ old('role') == 'petugas_kua' ? 'block' : 'none' }};">
                            <x-input-label for="master_kua_id" :value="__('Kantor Urusan Agama (KUA)')" />
                            <select id="master_kua_id" name="master_kua_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">-- Pilih KUA --</option>
                                @foreach($master_kua as $kua)
                                    <option value="{{ $kua->id }}" {{ old('master_kua_id') == $kua->id ? 'selected' : '' }}>
                                        {{ $kua->nama_kua }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('master_kua_id')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Akun') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const masterKuaField = document.getElementById('master-kua-field');
            const masterKuaSelect = document.getElementById('master_kua_id');

            // Fungsi untuk menampilkan/menyembunyikan field KUA
            function toggleKuaField() {
                if (roleSelect.value === 'petugas_kua') {
                    masterKuaField.style.display = 'block';
                } else {
                    masterKuaField.style.display = 'none';
                    masterKuaSelect.value = ''; // Kosongkan pilihan KUA jika role diganti
                }
            }

            // Panggil fungsi saat ada perubahan pada dropdown role
            roleSelect.addEventListener('change', toggleKuaField);

            // Panggil fungsi saat halaman pertama kali dimuat (untuk handle validasi error)
            toggleKuaField();
        });
    </script>
    @endpush
</x-app-layout>