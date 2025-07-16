{{-- resources/views/laporan/halaman/5_pendidikan_pengantin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Laporan Pendidikan Pengantin</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; margin: 0; }
        .page {
            position: relative;
            width: 29.7cm; /* LANDSCAPE */
            height: 21cm; /* LANDSCAPE */
        }
        .header, .footer {
            position: absolute;
            left: 2.5cm;
            right: 2.5cm;
        }
        .header { top: 1.5cm; }
        .footer { bottom: 1.5cm; }
        .content {
            padding-top: 6cm;  /* Space untuk header */
            padding-left: 2.5cm;
            padding-right: 2.5cm;
        }
        .data-table, .data-table th, .data-table td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px; /* Sedikit lebih kecil agar muat */
            font-size: 10pt; /* Ukuran font disesuaikan */
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="page">
        
        <div class="header">
            @include('laporan.partials.kop_surat')
        </div>

        <div class="content">
            {{-- JUDUL LAPORAN --}}
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <h4 style="font-weight: bold; text-decoration: underline; font-size: 14pt; margin: 0;">LAPORAN PENDIDIKAN TERAKHIR PENGANTIN</h4>
                <p style="font-size: 14pt; margin:0;">KECAMATAN {{ strtoupper($kua->nama_kua) }}</p>
                <p style="font-size: 14pt; margin:0;">Bulan: {{ $namaBulan }} Tahun: {{ $tahun }}</p>
            </div>
            
            {{-- TABEL DATA --}}
            <table class="data-table" style="width: 100%;">
                <thead style="font-weight: bold;">
                    <tr>
                        <td rowspan="2" style="vertical-align: middle;">NO</td>
                        <td rowspan="2" style="vertical-align: middle; width: 20%;">NAMA KECAMATAN</td>
                        <td colspan="7">PENDIDIKAN LAKI-LAKI (SUAMI)</td>
                        <td colspan="7">PENDIDIKAN PEREMPUAN (ISTRI)</td>
                        <td rowspan="2" style="vertical-align: middle;">JML NIKAH</td>
                    </tr>
                    <tr>
                        {{-- Asumsi kategori pendidikan --}}
                        <td>SD</td>
                        <td>SMP</td>
                        <td>SMA</td>
                        <td>D1-D3</td>
                        <td>S1</td>
                        <td>S2</td>
                        <td>S3</td>
                        <td>SD</td>
                        <td>SMP</td>
                        <td>SMA</td>
                        <td>D1-D3</td>
                        <td>S1</td>
                        <td>S2</td>
                        <td>S3</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Logika ini akan kita siapkan di LaporanController
                    @endphp
                    <tr>
                        <td>1</td>
                        <td>KUA Kecamatan {{ $kua->nama_kua }}</td>
                        {{-- Data Suami --}}
                        <td>{{ $pendidikanSuami['SD'] ?? 0 }}</td>
                        <td>{{ $pendidikanSuami['SMP'] ?? 0 }}</td>
                        <td>{{ $pendidikanSuami['SMA'] ?? 0 }}</td>
                        <td>{{ $pendidikanSuami['D1-D3'] ?? 0 }}</td>
                        <td>{{ $pendidikanSuami['S1'] ?? 0 }}</td>
                        <td>{{ $pendidikanSuami['S2'] ?? 0 }}</td>
                        <td>{{ $pendidikanSuami['S3'] ?? 0 }}</td>
                        {{-- Data Istri --}}
                        <td>{{ $pendidikanIstri['SD'] ?? 0 }}</td>
                        <td>{{ $pendidikanIstri['SMP'] ?? 0 }}</td>
                        <td>{{ $pendidikanIstri['SMA'] ?? 0 }}</td>
                        <td>{{ $pendidikanIstri['D1-D3'] ?? 0 }}</td>
                        <td>{{ $pendidikanIstri['S1'] ?? 0 }}</td>
                        <td>{{ $pendidikanIstri['S2'] ?? 0 }}</td>
                        <td>{{ $pendidikanIstri['S3'] ?? 0 }}</td>
                        <td>{{ $rekapDaftarNikah->count() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            {{-- TANDA TANGAN --}}
            <div style="width: 40%; margin-left: 60%; text-align: center;">
                <p>{{ $kua->nama_kua }}, {{ \Carbon\Carbon::create()->month($bulan)->day(cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun))->isoFormat('D MMMM Y') }}</p>
                <p>Kepala Kantor Urusan Agama</p>
                <p>Kecamatan {{ $kua->nama_kua }}</p>
                <div style="height: 70px;"></div>
                {{-- Data Dinamis --}}
                <p style="font-weight: bold; text-decoration: underline;">{{ $kepalaKua['nama'] }}</p>
                <p style="margin:0;">NIP. {{ $kepalaKua['nip'] }}</p>
            </div>
        </div>

    </div>
</body>
</html>