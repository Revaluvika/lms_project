<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        .container { padding: 20px; }
        .header { background-color: #f3f4f6; padding: 10px; border-radius: 5px; }
        .content { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pendaftaran Sekolah Baru</h2>
        </div>
        <div class="content">
            <p>Halo Admin Dinas,</p>
            <p>Terdapat pendaftaran sekolah baru yang perlu diverifikasi:</p>
            <ul>
                <li><strong>Nama Sekolah:</strong> {{ $school->name }}</li>
                <li><strong>NPSN:</strong> {{ $school->npsn }}</li>
                <li><strong>Jenjang:</strong> {{ $school->education_level }}</li>
                <li><strong>Alamat:</strong> {{ $school->address }}</li>
                <li><strong>Operator:</strong> {{ $school->admin->name ?? 'N/A' }} ({{ $school->admin->email ?? 'N/A' }})</li>
            </ul>
            <p>Silakan login ke dashboard untuk memverifikasi pendaftaran ini.</p>
            <p><a href="{{ route('dinas.schools.pending') }}">Buka Dashboard</a></p>
        </div>
    </div>
</body>
</html>
