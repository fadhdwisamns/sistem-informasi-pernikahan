{{-- resources/views/laporan/halaman/3_rekap_perceraian.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Laporan Data Perceraian</title>
    <style>
        /* CSS Anda tidak perlu diubah */
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
            <h4 style="font-weight: bold; text-align: center; font-size: 14pt; margin-bottom: 1rem;">LAPORAN DATA PERCERAIAN</h4>
            <p style="text-align: center;">Tahun: {{ $tahun }}</p>
            <table class="data-table" style="width: 100%; margin-top: 1rem;">
                <thead style="font-weight: bold; text-align: center;">
                    <tr>
                        <td style="width: 5%;">NO</td>
                        <td>NAMA KUA</td>
                        <td>JUMLAH PERCERAIAN</td>
                        <td>CERAI TALAK</td>
                        <td>CERAI GUGAT</td>
                        <td>AKTA CERAI TERBIT</td>
                        <td>TANGGAL REKAP</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">1</td>
                        <td>{{ $kua->nama_kua }}</td>
                        <td style="text-align: center;">{{ $rekapPerceraian->count() }}</td>
                        {{-- Logika untuk Cerai Talak/Gugat perlu disesuaikan jika ada datanya di model --}}
                        <td style="text-align: center;">{{-- Ganti dengan count Cerai Talak --}}</td>
                        <td style="text-align: center;">{{-- Ganti dengan count Cerai Gugat --}}</td>
                        <td style="text-align: center;">{{ $rekapPerceraian->count() }}</td>
                        <td style="text-align: center;">{{ now()->format('d/m/Y') }}</td>
                    </tr>
                     @if($rekapPerceraian->isEmpty())
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
                <p>Kepala Kantor Urusan Agama</p>
                <p>Kecamatan {{ $kua->nama_kua }}</p>
                <div style="height: 70px;"></div>
                <p style="font-weight: bold; text-decoration: underline;">Marwis, S.Ag</p>
                <p>NIP. 197106172005011002</p>
            </div>
        </div>
    </div>
</body>
</html>