<!--resources/views/admin/students/report-pdf.blade.php-->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport {{ $student->nama }}</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .school-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .school-address {
            font-size: 12px;
            margin-bottom: 10px;
        }
        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0;
        }
        .student-info {
            margin: 20px 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .info-table td {
            padding: 5px 10px;
            border: 1px solid #ddd;
        }
        .info-table .label {
            font-weight: bold;
            width: 30%;
            background-color: #f5f5f5;
        }
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .grades-table th,
        .grades-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        .grades-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .summary {
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #333;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
        }
        .signature-area {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            text-align: center;
            width: 45%;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        .grade-A { color: #059669; font-weight: bold; }
        .grade-B { color: #2563eb; font-weight: bold; }
        .grade-C { color: #d97706; font-weight: bold; }
        .grade-D { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">MADRASAH / SEKOLAH TK PERCOBAAN</div>
        <div class="school-address">Alamat: Jl. Pendidikan No. 123, Kota Contoh</div>
        <div class="report-title">LAPORAN HASIL BELAJAR SISWA</div>
        <div>Tahun Ajaran: {{ $tahunAjaran }}</div>
    </div>

    <!-- Informasi Siswa -->
    <div class="student-info">
        <table class="info-table">
            <tr>
                <td class="label">Nama Siswa</td>
                <td>{{ $student->nama }}</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td>{{ $student->kelas }}</td>
            </tr>
            <tr>
                <td class="label">ID Siswa</td>
                <td>{{ $student->id }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td>{{ $tanggal }}</td>
            </tr>
        </table>
    </div>

    <!-- Nilai Mata Pelajaran -->
    <div class="report-title">HASIL BELAJAR</div>
    
    @if($nilaiPerMapel->count() > 0)
        <table class="grades-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mata Pelajaran / Aspek</th>
                    <th>Nilai Rata-rata</th>
                    <th>Nilai Tertinggi</th>
                    <th>Nilai Terendah</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilaiPerMapel as $mapel => $data)
                @php
                    $grade = $data['rata_rata'] >= 85 ? 'A' : 
                            ($data['rata_rata'] >= 70 ? 'B' : 
                            ($data['rata_rata'] >= 60 ? 'C' : 'D'));
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: left; padding-left: 15px;">{{ $mapel }}</td>
                    <td>{{ number_format($data['rata_rata'], 2) }}</td>
                    <td>{{ $data['nilai_tertinggi'] }}</td>
                    <td>{{ $data['nilai_terendah'] }}</td>
                    <td class="grade-{{ $grade }}">{{ $grade }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #666; font-style: italic;">
            Belum ada data nilai untuk siswa ini.
        </p>
    @endif

    <!-- Ringkasan -->
    <div class="summary">
        <div style="font-weight: bold; margin-bottom: 15px; text-align: center;">
            RINGKASAN HASIL BELAJAR
        </div>
        <div class="summary-item">
            <span>Total Mata Pelajaran:</span>
            <span>{{ $nilaiPerMapel->count() }}</span>
        </div>
        <div class="summary-item">
            <span>Total Nilai:</span>
            <span>{{ $student->nilai_count }}</span>
        </div>
        <div class="summary-item">
            <span>Nilai Rata-rata Keseluruhan:</span>
            <span>{{ number_format($student->rata_rata, 2) }}</span>
        </div>
        <div class="summary-item">
            <span>Nilai Tertinggi:</span>
            <span>{{ $student->nilai_tertinggi }}</span>
        </div>
        <div class="summary-item">
            <span>Nilai Terendah:</span>
            <span>{{ $student->nilai_terendah }}</span>
        </div>
        <div class="summary-item">
            <span>Grade Akhir:</span>
            <span class="grade-{{ $student->grade }}">{{ $student->grade }}</span>
        </div>
    </div>

    <!-- Keterangan Grade -->
    <div style="margin-top: 20px; font-size: 12px;">
        <strong>Keterangan Grade:</strong><br>
        A = Sangat Baik (85-100), B = Baik (70-84), C = Cukup (60-69), D = Perlu Bimbingan (≤59)
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-area">
        <div class="signature">
            Orang Tua/Wali<br>
            <div class="signature-line">(___________________)</div>
        </div>
        <div class="signature">
            Guru Kelas<br>
            <div class="signature-line">(___________________)</div>
        </div>
    </div>

    <div class="footer">
        Dokumen ini dicetak secara elektronik pada {{ $tanggal }}
    </div>
</body>
</html>