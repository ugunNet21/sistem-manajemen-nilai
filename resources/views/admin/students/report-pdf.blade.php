<!--resources/views/admin/students/report-pdf.blade.php-->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport {{ $student->nama }}</title>
    <style>
        @page {
            margin: 25px;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            line-height: 1.4;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .school-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .school-address {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
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
            padding: 6px 10px;
        }
        .info-table .label {
            font-weight: bold;
            width: 25%;
        }
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            page-break-inside: avoid; /* Mencegah tabel terpotong */
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
            background-color: #f9f9f9;
            page-break-inside: avoid; /* Mencegah ringkasan terpotong */
        }
        .summary-item {
            padding: 4px 0;
        }
        .summary-item span {
            display: inline-block;
        }
        .summary-item span:first-child {
            width: 60%;
        }
        .summary-item span:last-child {
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .signature-table {
            width: 100%;
            margin-top: 50px;
            page-break-inside: avoid; /* Mencegah area ttd terpotong */
        }
        .signature-table td {
            text-align: center;
            width: 50%;
            padding: 10px;
        }
        .signature-line {
            margin-top: 70px;
            font-weight: bold;
        }
        .grade-A { color: #059669; font-weight: bold; }
        .grade-B { color: #2563eb; font-weight: bold; }
        .grade-C { color: #d97706; font-weight: bold; }
        .grade-D { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">MADRASAH SYARI'UL JANNAH</div>
        <div class="school-address">Alamat: Jl. Pasar Sindanglaya No. RT 06 RW 01, KOTA BANDUNG</div>
        <div class="report-title">Laporan Hasil Belajar Siswa</div>
        <div>Tahun Ajaran: {{ $tahunAjaran }}</div>
    </div>

    <!-- Informasi Siswa -->
    <table class="info-table">
        <tr>
            <td class="label">Nama Siswa</td>
            <td>: {{ $student->nama }}</td>
            <td class="label">Kelas</td>
            <td>: {{ $student->kelas }}</td>
        </tr>
        <tr>
            <td class="label">ID Siswa</td>
            <td>: {{ $student->id }}</td>
            <td class="label">Tanggal Cetak</td>
            <td>: {{ $tanggal }}</td>
        </tr>
    </table>

    <!-- Nilai Mata Pelajaran -->
    <div class="report-title" style="text-align: center;">Hasil Belajar</div>
    
    @if($nilaiPerMapel->count() > 0)
        <table class="grades-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Mata Pelajaran / Aspek</th>
                    <th style="width: 15%;">Nilai Rata-rata</th>
                    <th style="width: 15%;">Nilai Tertinggi</th>
                    <th style="width: 15%;">Nilai Terendah</th>
                    <th style="width: 10%;">Grade</th>
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
        <p style="text-align: center; color: #666; font-style: italic; padding: 30px; border: 1px dashed #ccc;">
            Belum ada data nilai untuk siswa ini.
        </p>
    @endif

    <!-- Ringkasan -->
    <div class="summary">
        <div style="font-weight: bold; margin-bottom: 10px; text-align: center; font-size: 14px;">
            RINGKASAN HASIL BELAJAR
        </div>
        <div class="summary-item">
            <span>Total Mata Pelajaran</span>
            <span>: {{ $nilaiPerMapel->count() }}</span>
        </div>
        <div class="summary-item">
            <span>Rata-rata Nilai Keseluruhan</span>
            <span>: {{ number_format($student->rata_rata, 2) }}</span>
        </div>
        <div class="summary-item">
            <span>Nilai Tertinggi Keseluruhan</span>
            <span>: {{ $student->nilai_tertinggi }}</span>
        </div>
        <div class="summary-item">
            <span>Nilai Terendah Keseluruhan</span>
            <span>: {{ $student->nilai_terendah }}</span>
        </div>
        <div class="summary-item">
            <span>Grade Akhir</span>
            <span>: <span class="grade-{{ $student->grade }}">{{ $student->grade }}</span></span>
        </div>
    </div>

    <!-- Keterangan Grade -->
    <div style="margin-top: 20px; font-size: 11px;">
        <strong>Keterangan Grade:</strong>
        A = Sangat Baik (85-100), B = Baik (70-84), C = Cukup (60-69), D = Perlu Bimbingan (≤59)
    </div>

    <!-- Tanda Tangan -->
    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>Orang Tua/Wali Murid
                <div class="signature-line">(___________________)</div>
            </td>
            <td>
                Kota Contoh, {{ $tanggal }}<br>Guru Kelas
                <div class="signature-line">(___________________)</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen ini dicetak secara elektronik dan dianggap sah tanpa tanda tangan basah.
    </div>
</body>
</html>
