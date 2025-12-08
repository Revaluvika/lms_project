<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        .container { padding: 20px; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selamat! Pendaftaran Sekolah Anda Disetujui</h2>
        <p>Halo Admin {{ $school->name }},</p>
        <p>Kami dengan senang hati menginformasikan bahwa pendaftaran sekolah Anda telah disetujui oleh Dinas Pendidikan.</p>
        <p>Sekarang Anda dapat login dan mengakses dashboard sekolah Anda secara penuh.</p>
        <p><a href="{{ route('login') }}">Login ke Dashboard</a></p>
    </div>
</body>
</html>
