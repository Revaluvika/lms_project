<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        .container { padding: 20px; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Status Pendaftaran Sekolah</h2>
        <p>Halo Admin {{ $school->name }},</p>
        <p>Mohon maaf, pendaftaran sekolah Anda saat ini <strong class="error">Ditolak</strong> oleh Dinas Pendidikan.</p>
        <p><strong>Alasan Penolakan:</strong></p>
        <blockquote style="background: #f9f9f9; padding: 10px; border-left: 5px solid red;">
            {{ $reason }}
        </blockquote>
        <p>Silakan perbaiki data atau dokumen Anda dan lakukan pendaftaran ulang, atau hubungi Dinas Pendidikan untuk informasi lebih lanjut.</p>
    </div>
</body>
</html>
