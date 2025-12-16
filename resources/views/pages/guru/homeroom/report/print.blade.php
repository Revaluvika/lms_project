<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor - {{ $student->user->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2, .header h3 { margin: 2px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .table th, .table td { border: 1px solid black; padding: 5px; }
        .no-border { border: none !important; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .mb-2 { margin-bottom: 10px; }
        .section-title { font-weight: bold; margin-top: 15px; margin-bottom: 5px; border-bottom: 1px solid black; display: inline-block; }
    </style>
</head>
<body>
    <div class="header">
        <h3>RAPOR PESERTA DIDIK</h3>
        <h2>{{ strtoupper($classroom->school->name ?? 'SEKOLAH') }}</h2>
        <p>Tahun Pelajaran: {{ $classroom->academicYear->name }} - Semester {{ ucfirst($classroom->academicYear->semester) }}</p>
    </div>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td class="no-border" style="width: 15%">Nama Peserta Didik</td>
            <td class="no-border" style="width: 35%">: {{ $student->user->name }}</td>
            <td class="no-border" style="width: 15%">Kelas</td>
            <td class="no-border" style="width: 35%">: {{ $classroom->name }}</td>
        </tr>
        <tr>
            <td class="no-border">NIS / NISN</td>
            <td class="no-border">: {{ $student->nis }} / {{ $student->nisn }}</td>
            <td class="no-border">Fase</td>
            <td class="no-border">: - (Kurikulum Merdeka)</td>
        </tr>
    </table>

    <div class="section-title">A. NILAI AKADEMIK</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>Mata Pelajaran</th>
                <th style="width: 10%">Nilai Akhir</th>
                <th style="width: 40%">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $index => $grade)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $grade->subject->name }}</td>
                <td class="text-center">{{ $grade->final_grade }}</td>
                <td>{{ $grade->comments ?? '-' }}</td> {{-- Assuming comments/skills description exists --}}
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">B. EKSTRAKURIKULER</div>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kegiatan Ekstrakurikuler</th>
                <th>Predikat</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ekskul as $index => $ek)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $ek->activity_name }}</td>
                <td class="text-center">{{ $ek->grade }}</td>
                <td>{{ $ek->description }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">-</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">C. KETIDAKHADIRAN</div>
    <table class="table" style="width: 50%">
        <tr>
            <td>Sakit</td>
            <td>: {{ $termRecord->sick_count ?? 0 }} hari</td>
        </tr>
        <tr>
            <td>Izin</td>
            <td>: {{ $termRecord->permission_count ?? 0 }} hari</td>
        </tr>
        <tr>
            <td>Tanpa Keterangan</td>
            <td>: {{ $termRecord->absentee_count ?? 0 }} hari</td>
        </tr>
    </table>

    <div class="section-title">D. CATATAN WALI KELAS</div>
    <div style="border: 1px solid black; padding: 10px; min-height: 60px;">
        {{ $termRecord->notes ?? '-' }}
    </div>

    @if($termRecord->promotion_status && $classroom->academicYear->semester == 'genap')
    <div class="section-title">KEPUTUSAN</div>
    <div style="border: 1px solid black; padding: 10px;">
        Berdasarkan hasil pencapaian kompetensi peserta didik, ditetapkan:<br>
        <strong>
        @if($termRecord->promotion_status == 'promoted')
            NAIK KE KELAS BERIKUTNYA
        @elseif($termRecord->promotion_status == 'retained')
            TINGGAL DI KELAS SAAT INI
        @elseif($termRecord->promotion_status == 'graduated')
            LULUS
        @else
            -
        @endif
        </strong>
    </div>
    @endif

    <br><br>
    <table style="width: 100%">
        <tr>
            <td class="no-border" style="width: 33%; text-align: center;">
                <br>
                Orang Tua / Wali<br><br><br><br>
                _______________________
            </td>
            <td class="no-border" style="width: 33%; text-align: center;">
                <br>
                Kepala Sekolah<br><br><br><br>
                _______________________
            </td>
            <td class="no-border" style="width: 33%; text-align: center;">
                {{ $classroom->school->address_details['district'] ?? 'Kota' }}, {{ date('d F Y') }}<br>
                Wali Kelas<br><br><br><br>
                <strong>{{ Auth::user()->name }}</strong>
            </td>
        </tr>
    </table>
    
    <script>
        window.print();
    </script>
</body>
</html>
