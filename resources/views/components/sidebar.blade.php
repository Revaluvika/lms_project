<div class="w-64 bg-white shadow-lg h-screen fixed left-0 top-0 p-6">
    <h1 class="text-xl font-bold mb-8">LearnFlux</h1>

    @php
        $role = Auth::user()->role;
    @endphp

    <ul class="space-y-4">

        {{-- DASHBOARD --}}
        <li>
            <a href="{{ route('dashboard.' . ($role === 'kepala_sekolah' ? 'kepsek' : ($role === 'guru' ? 'guru' : ($role === 'siswa' ? 'siswa' : ($role === 'orang_tua' ? 'orangtua' : 'dinas'))))) }}"
                class="flex items-center space-x-3 text-gray-700 hover:text-blue-600">
                {!! file_get_contents(public_path('icons/dashboard.svg')) !!}
                <span>Dashboard</span>
            </a>
        </li>

        {{-- MENU GURU --}}
        @if ($role === 'guru')
            <li>
                <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600">
                    {!! file_get_contents(public_path('icons/data-guru.svg')) !!}
                    <span>Data Guru</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600">
                    {!! file_get_contents(public_path('icons/jadwal.svg')) !!}
                    <span>Jadwal</span>
                </a>
            </li>
        @endif

        {{-- MENU SISWA --}}
        @if ($role === 'siswa')
            <li>
                <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600">
                    {!! file_get_contents(public_path('icons/data-siswa.svg')) !!}
                    <span>Data Siswa</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600">
                    {!! file_get_contents(public_path('icons/nilai.svg')) !!}
                    <span>Nilai</span>
                </a>
            </li>
        @endif

        {{-- MENU KEPALA SEKOLAH --}}
        @if ($role === 'kepala_sekolah')
            <li>
                <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600">
                    {!! file_get_contents(public_path('icons/laporan.svg')) !!}
                    <span>Laporan Sekolah</span>
                </a>
            </li>
        @endif

        {{-- MENU DINAS --}}
        @if ($role === 'dinas')
            <li>
                <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600">
                    {!! file_get_contents(public_path('icons/dinas.svg')) !!}
                    <span>Dashboard Dinas</span>
                </a>
            </li>
        @endif

        {{-- MENU ORANGTUA --}}
        @if ($role === 'orang_tua')
            <li>
                <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600">
                    {!! file_get_contents(public_path('icons/profil.svg')) !!}
                    <span>Profil Anak</span>
                </a>
            </li>
        @endif

        {{-- LOGOUT --}}
        <li class="pt-10">
            <a href="{{ route('logout') }}" class="flex items-center space-x-3 text-red-600 hover:text-red-800">
                {!! file_get_contents(public_path('icons/logout.svg')) !!}
                <span>Logout</span>
            </a>
        </li>

    </ul>
</div>
