@extends('layouts.app')

@section('title', 'LearnFlux - Smart Learning Management System')

@section('content')
    {{-- NAVBAR --}}
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="shrink-0 flex items-center">
                    <span
                        class="text-2xl font-bold bg-clip-text text-transparent bg-linear-to-r from-blue-600 to-indigo-600">
                        LearnFlux
                    </span>
                </div>
                <div>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-sm">
                        Masuk / Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="pt-32 pb-20 bg-linear-to-b from-blue-50 to-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">
                Transformasi Pendidikan <br class="hidden md:block" />
                <span class="text-blue-600">Era Digital</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 mb-10">
                Platform pembelajaran terintegrasi untuk menghubungkan sekolah, guru, siswa, dan orang tua dalam satu
                ekosistem cerdas.
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}"
                    class="px-8 py-4 bg-blue-600 text-white font-bold rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    Mulai Sekarang
                </a>
                <a href="#features"
                    class="px-8 py-4 bg-white text-blue-600 font-bold rounded-full shadow hover:bg-gray-50 transition duration-300 border border-gray-200">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Mengapa Memilih LearnFlux?</h2>
                <p class="mt-4 text-lg text-gray-600">Solusi lengkap untuk semua kebutuhan pendidikan modern</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div
                    class="p-8 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 border border-transparent hover:border-gray-100 group">
                    <div
                        class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                        <x-icons.dinas class="w-8 h-8 text-blue-600" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Monitoring Terpusat</h3>
                    <p class="text-gray-600">Dinas pendidikan dapat memantau kualitas dan perkembangan sekolah secara
                        real-time.</p>
                </div>

                {{-- Feature 2 --}}
                <div
                    class="p-8 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 border border-transparent hover:border-gray-100 group">
                    <div
                        class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                        <x-icons.kepsek class="w-8 h-8 text-indigo-600" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Sekolah</h3>
                    <p class="text-gray-600">Kepala sekolah memiliki kontrol penuh atas administrasi dan kinerja staf
                        pengajar.</p>
                </div>

                {{-- Feature 3 --}}
                <div
                    class="p-8 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 border border-transparent hover:border-gray-100 group">
                    <div
                        class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                        <x-icons.guru class="w-8 h-8 text-purple-600" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Kelas Digital Interaktif</h3>
                    <p class="text-gray-600">Guru dapat mengelola materi, tugas, dan penilaian dengan mudah dan efisien.</p>
                </div>

                {{-- Feature 4 --}}
                <div
                    class="p-8 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 border border-transparent hover:border-gray-100 group">
                    <div
                        class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                        <x-icons.siswa class="w-8 h-8 text-green-600" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Akses Belajar Fleksibel</h3>
                    <p class="text-gray-600">Siswa dapat mengakses materi pelajaran dan ujian dari mana saja dan kapan saja.
                    </p>
                </div>

                {{-- Feature 5 --}}
                <div
                    class="p-8 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 border border-transparent hover:border-gray-100 group">
                    <div
                        class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                        <x-icons.orangtua class="w-8 h-8 text-orange-600" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Keterlibatan Orang Tua</h3>
                    <p class="text-gray-600">Orang tua dapat memantau kehadiran dan prestasi akademik anak secara
                        transparan.</p>
                </div>

                {{-- CTA Card --}}
                <div class="p-8 bg-blue-600 rounded-2xl text-white flex flex-col justify-center items-center text-center">
                    <h3 class="text-xl font-bold mb-3">Siap Bergabung?</h3>
                    <p class="text-blue-100 mb-6">Mulai perjalanan pendidikan digital Anda hari ini bersama LearnFlux.</p>
                    <a href="{{ route('school.register') }}"
                        class="inline-block w-full py-3 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition">
                        Masuk Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-300 py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <span class="text-2xl font-bold text-white mb-4 block">LearnFlux</span>
                <p class="text-gray-400 max-w-xs">Membangun masa depan pendidikan Indonesia dengan teknologi yang
                    terintegrasi dan mudah digunakan.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Platform</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white transition">Fitur</a></li>
                    <li><a href="#" class="hover:text-white transition">Sekolah</a></li>
                    <li><a href="#" class="hover:text-white transition">Panduan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Hubungi Kami</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white transition">Bantuan</a></li>
                    <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                    <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} LearnFlux LMS. Semua Hak Dilindungi.
        </div>
    </footer>
@endsection
