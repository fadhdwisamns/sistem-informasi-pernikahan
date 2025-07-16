{{-- resources/views/laporan/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Buat Laporan Bulanan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pilih Periode Laporan</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Pilih bulan, tahun, dan KUA (jika Anda admin) untuk membuat laporan yang siap dicetak.
                </p>

                {{-- Atribut 'action' pada form dihapus karena sudah di-handle oleh tombol --}}
                <form method="GET" class="mt-6 space-y-6">

                    {{-- BAGIAN UNTUK ADMIN (SUDAH BENAR) --}}
                    @if(Auth::user()->role === 'admin')
                    <div>
                        <x-input-label for="kua_id" value="{{ __('Pilih KUA') }}" />
                        <select id="kua_id" name="kua_id" class="block w-full mt-1 rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300" required>
                            <option value="">-- Pilih Salah Satu KUA --</option> {{-- Diubah agar lebih jelas --}}
                            @foreach($kuas as $kua)
                                <option value="{{ $kua->id }}">{{ $kua->nama_kua }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('kua_id')" class="mt-2" />
                    </div>
                    @endif

                    {{-- BAGIAN FILTER (SUDAH BENAR) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="bulan" value="{{ __('Bulan') }}" />
                            <select id="bulan" name="bulan" class="block w-full mt-1 rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300">
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('bulan')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="tahun" value="{{ __('Tahun') }}" />
                            <select id="tahun" name="tahun" class="block w-full mt-1 rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('tahun')" class="mt-2" />
                        </div>
                    </div>

                        <div class="mt-6 flex items-center justify-end space-x-4">
        
                            {{-- Tombol untuk Laporan Gabungan KUA (tanpa perceraian) --}}
                            <button type="submit" 
                                    formaction="{{ route('laporan.show') }}"
                                   class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cetak Laporan KUA
                            </button>

                            {{-- Tombol KHUSUS untuk Laporan Perceraian --}}
                            <button type="submit" 
                                    formaction="{{ route('laporan.perceraian') }}"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cetak Laporan Cerai
                            </button>

                        </div>
                    </form>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>