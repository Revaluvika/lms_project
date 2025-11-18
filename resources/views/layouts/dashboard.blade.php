<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnFlux Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Topbar --}}
    @include('components.topbar')

    {{-- Konten Halaman --}}
    <div class="ml-64 mt-20 p-8">
        @yield('content')
    </div>

</body>
</html>
