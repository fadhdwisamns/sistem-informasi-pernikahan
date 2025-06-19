<aside class="w-64 flex-shrink-0 bg-gray-800 text-gray-300 flex flex-col" x-data>
    <a href="{{ route('dashboard') }}" class="h-20 flex items-center justify-center bg-gray-900 shadow-md">
        <div class="flex items-center space-x-3 px-4">
             <svg class="h-10 w-10 text-cyan-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A11.953 11.953 0 0112 13.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 003 12c0 .778.099 1.533.284 2.253m0 0a11.953 11.953 0 00-2.288 4.918M3.284 14.253a11.953 11.953 0 012.288 4.918" />
            </svg>
            <span class="font-bold text-lg text-white">SIPENPA</span>
        </div>
    </a>
    
    <nav class="flex-grow px-4 py-4 space-y-2">
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200
                  {{ request()->routeIs('dashboard') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Dashboard</span>
        </a>

        {{-- ================== MENU KHUSUS ADMIN ================== --}}
        
        @if(auth()->user()->role == 'admin')
            <p class="px-3 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin Menu</p>

            {{-- Master Akun --}}
            @if(Route::has('admin.users.index'))
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200
                         {{ request()->routeIs('admin.users.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="h-6 w-6 mr-3" ...></svg>
                    <span>Master Akun</span>
                </a>
            @endif

            {{-- Verifikasi Data --}}
            @if(Route::has('admin.verification.index'))
                <a href="{{ route('admin.verification.index') }}"
                   class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200
                         {{ request()->routeIs('admin.verification.*') || request()->routeIs('admin.perceraians.show_verify_form') || request()->routeIs('admin.pernikahan.show_verify_form') || request()->routeIs('admin.rujuk.show_verify_form') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="h-6 w-6 mr-3" ...></svg>
                    <span>Verifikasi Data</span>
                </a>
            @endif

             {{-- Link Laporan (Untuk Admin) --}}
            <a href="{{ route('laporan.index') }}" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200
                     {{ request()->routeIs('laporan.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-5m-2 5h4m-4 0a2 2 0 01-2-2v-5a2 2 0 012-2h4a2 2 0 012 2v5a2 2 0 01-2 2zM3 8a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                <span>Laporan</span>
            </a>
        @endif

        {{-- ================== MENU KHUSUS PETUGAS KUA ================== --}}
        @if(auth()->user()->role == 'petugas_kua')
            <a href="{{ route('petugas-kua.pernikahan.index') }}" 
            class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200
                    {{ request()->routeIs('petugas-kua.pernikahan.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <span>Data Pernikahan & Rujuk</span>
            </a>
            <a href="{{ route('petugas-kua.rujuk.index') }}" 
            class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200
                {{ request()->routeIs('petugas-kua.rujuk.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <span>Data Rujuk</span>
            </a>
           <a href="{{ route('petugas-kua.perceraians.index') }}" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200
                    {{ request()->routeIs('petugas-kua.perceraians.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="h-6 w-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Data Perceraian</span>
            </a>
        @endif
        
        {{-- ... menu untuk Petugas PA ... --}}
        @if(auth()->user()->role == 'petugas_pa')
            <p class="px-3 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Petugas PA Menu</p>
            <a href="{{ route('petugas-pa.perceraians.index') }}" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200
                    {{ request()->routeIs('petugas-pa.perceraians.*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg> {{-- External Link/Document Icon --}}
                <span>Data Perceraian</span>
            </a>
            
        @endif

    </nav>

    <div class="px-4 py-3 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 text-gray-300 hover:bg-red-500 hover:text-white">
                <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>