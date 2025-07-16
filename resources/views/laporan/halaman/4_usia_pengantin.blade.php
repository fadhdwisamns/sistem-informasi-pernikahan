{{-- resources/views/laporan/halaman/4_usia_pengantin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Laporan Usia Pengantin</title>
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
            left: 2.5cm; /* Menambah margin kiri */
            right: 2.5cm; /* Menambah margin kanan */
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
            padding: 6px;
            font-size: 11pt;
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
                <h4 style="font-weight: bold; text-decoration: underline; font-size: 14pt; margin: 0;">LAPORAN USIA PENGANTIN</h4>
                <p style="font-size: 14pt; margin:0;">KECAMATAN {{ strtoupper($kua->nama_kua) }}</p>
                <p style="font-size: 14pt; margin:0;">Tahun: {{ $tahun }}</p>
            </div>
            
            {{-- TABEL DATA --}}
            <table class="data-table" style="width: 100%; text-align: center;">
                <thead style="font-weight: bold;">
                    <tr>
                        <td rowspan="2" style="vertical-align: middle;">NO</td>
                        <td rowspan="2" style="vertical-align: middle;">NAMA KECAMATAN</td>
                        <td colspan="3">USIA LAKI-LAKI</td>
                        <td colspan="3">USIA PENGANTIN</td>
                        <td rowspan="2" style="vertical-align: middle;">JML NIKAH</td>
                    </tr>
                    <tr>
                        <td>&lt; 19 thn<br>(1)</td>
                        <td>19-21 thn<br>(2)</td>
                        <td>21+ thn<br>(3)</td>
                        <td>&lt; 19 thn<br>(4)</td>
                        <td>19-21 thn<br>(5)</td>
                        <td>21+ thn<br>(6)</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $rekap = $rekapDaftarNikah; // Menggunakan alias agar lebih pendek
                        $suami_under_19 = $rekap->where('usia_suami', '<', 19)->count();
                        $suami_19_21 = $rekap->whereBetween('usia_suami', [19, 21])->count();
                        $suami_over_21 = $rekap->where('usia_suami', '>', 21)->count();
                        $istri_under_19 = $rekap->where('usia_istri', '<', 19)->count();
                        $istri_19_21 = $rekap->whereBetween('usia_istri', [19, 21])->count();
                        $istri_over_21 = $rekap->where('usia_istri', '>', 21)->count();
                    @endphp
                    <tr>
                        <td>1</td>
                        <td>KUA Kecamatan {{ $kua->nama_kua }}</td>
                        <td>{{ $suami_under_19 }}</td>
                        <td>{{ $suami_19_21 }}</td>
                        <td>{{ $suami_over_21 }}</td>
                        <td>{{ $istri_under_19 }}</td>
                        <td>{{ $istri_19_21 }}</td>
                        <td>{{ $istri_over_21 }}</td>
                        <td>{{ $rekap->count() }}</td>
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