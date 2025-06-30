{{-- resources/views/laporan/halaman/2_rekap_nikah.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Laporan Peristiwa Nikah dan Rujuk</title>
    <style>
        /* CSS Anda tidak perlu diubah, jadi saya sembunyikan untuk keringkasan */
        @page { margin: 0; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; margin: 0; }
        .page { position: relative; width: 29.7cm; height: 21cm; }
        .header, .footer { position: absolute; left: 1.5cm; right: 1.5cm; }
        .header { top: 1.5cm; }
        .footer { bottom: 1.5cm; }
        .content { padding-top: 5.5cm; padding-left: 1.5cm; padding-right: 1.5cm; }
        .data-table, .data-table th, .data-table td { border: 1px solid black; border-collapse: collapse; padding: 5px; font-size: 11pt; }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            @include('laporan.partials.kop_surat')
        </div>

        <div class="content">
            <h4 style="font-weight: bold; text-align: center; font-size: 14pt; margin-bottom: 0;">LAPORAN PERISTIWA NIKAH/RUJUK</h4>
            <h4 style="font-weight: bold; text-align: center; font-size: 14pt; margin-top: 0; margin-bottom: 1rem;">KANTOR URUSAN AGAMA KECAMATAN {{ strtoupper($kua->nama_kua) }}</h4>
            <p style="text-align: center;">Bulan: {{ $namaBulan }} {{ $tahun }}</p>
            
            <table class="data-table" style="width: 100%; margin-top: 1rem;">
                <thead style="font-weight: bold; text-align: center;">
                    <tr>
                        <td rowspan="2" style="width: 5%; vertical-align: middle;">NO</td>
                        <td rowspan="2" style="vertical-align: middle;">NAMA KUA</td>
                        <td rowspan="2" style="vertical-align: middle;">JUMLAH NIKAH</td>
                        <td rowspan="2" style="vertical-align: middle;">JUMLAH RUJUK</td>
                        <td colspan="2">JUMLAH NASAB</td>
                        <td rowspan="2" style="vertical-align: middle;">KETERANGAN</td>
                    </tr>
                    <tr>
                        <td>SUAMI</td>
                        <td>ISTRI</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">1</td>
                        <td>{{ $kua->nama_kua }}</td>
                        <td style="text-align: center;">{{ $rekapDaftarNikah->count() }}</td>
                        <td style="text-align: center;">{{ $rekapRujuk->count() }}</td>
                        {{-- Asumsi Nasab adalah jumlah suami/istri dari data nikah. Jika ada logika lain, sesuaikan di sini --}}
                        <td style="text-align: center;">{{ $rekapDaftarNikah->count() }}</td>
                        <td style="text-align: center;">{{ $rekapDaftarNikah->count() }}</td>
                        <td></td>
                    </tr>
                    {{-- Baris kosong untuk estetika jika hanya ada satu KUA --}}
                    @if($rekapDaftarNikah->isEmpty() && $rekapRujuk->isEmpty())
                    <tr>
                        <td colspan="7" style="text-align: center; height: 50px;">Tidak ada data untuk periode ini.</td>
                    </tr>
                    @else
                    <tr>
                         <td style="height: 30px;"></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="footer">
            <div style="width: 40%; margin-left: 60%; text-align: center;">
                <p>{{ $kua->nama_kua }}, {{ now()->isoFormat('D MMMM Y') }}</p>
                <p>Kepala</p>
                <div style="height: 70px;"></div>
                <p style="font-weight: bold; text-decoration: underline;">Marwis, S.Ag</p>
                <p>NIP. 197106172005011002</p>
            </div>
        </div>
    </div>
</body>
</html>