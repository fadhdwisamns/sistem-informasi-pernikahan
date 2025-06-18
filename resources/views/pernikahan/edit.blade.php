<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Data Pernikahan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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
                    <form method="POST" action="{{ route('petugas-kua.pernikahan.update', $pernikahan) }}" class="space-y-6">
                        @csrf
                        @method('PATCH') {{-- atau PUT --}}

                        <div>
                            <x-input-label for="no_akta" :value="__('Nomor Akta Nikah')" />
                            {{-- old() akan mengambil data lama dari validasi, jika tidak ada, ambil dari $pernikahan --}}
                            <x-text-input id="no_akta" name="no_akta" type="text" class="mt-1 block w-full" :value="old('no_akta', $pernikahan->no_akta)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('no_akta')" />
                        </div>
                        
                         <div>
                            <x-input-label for="tanggal_akad" :value="__('Tanggal Akad')" />
                            <x-text-input id="tanggal_akad" name="tanggal_akad" type="date" class="mt-1 block w-full" :value="old('tanggal_akad', $pernikahan->tanggal_akad)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_akad')" />
                        </div>
                        <div>
                            <x-input-label for="nama_suami" :value="__('Nama Suami')" />
                            <x-text-input id="nama_suami" name="nama_suami" type="text" class="mt-1 block w-full"
                                :value="old('nama_suami', $pernikahan->nama_suami)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_suami')" />
                        </div>

                        <div>
                            <x-input-label for="nik_suami" :value="__('NIK Suami')" />
                            <x-text-input id="nik_suami" name="nik_suami" type="text" class="mt-1 block w-full"
                                :value="old('nik_suami', $pernikahan->nik_suami)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nik_suami')" />
                        </div>

                        <div>
                            <x-input-label for="nama_istri" :value="__('Nama Istri')" />
                            <x-text-input id="nama_istri" name="nama_istri" type="text" class="mt-1 block w-full"
                                :value="old('nama_istri', $pernikahan->nama_istri)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_istri')" />
                        </div>

                        <div>
                            <x-input-label for="nik_istri" :value="__('NIK Istri')" />
                            <x-text-input id="nik_istri" name="nik_istri" type="text" class="mt-1 block w-full"
                                :value="old('nik_istri', $pernikahan->nik_istri)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nik_istri')" />
                        </div>
                        
                        {{-- Lanjutkan untuk semua field lainnya, polanya sama --}}

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>