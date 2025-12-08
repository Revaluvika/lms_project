<!DOCTYPE html>
<html lang="id">

<head>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnFlux Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Topbar (sudah ada notifikasi di dalamnya) --}}
    @include('components.topbar')

    {{-- Konten Halaman --}}
    <div class="ml-64 mt-16 p-8">
        @yield('content')
    </div>

</body>
</html>
