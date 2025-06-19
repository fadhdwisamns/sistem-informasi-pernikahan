{{-- resources/views/laporan/halaman/4_rekap_rujuk.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Rekapitulasi Rujuk</title>
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
            left: 1.5cm;
            right: 1.5cm;
        }
        .header { top: 1.5cm; }
        .footer { bottom: 1.5cm; }
        .content {
            padding-top: 5.5cm;  /* Sesuaikan space untuk header */
            padding-left: 1.5cm;
            padding-right: 1.5cm;
        }
        .data-table, .data-table th, .data-table td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
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
            <h4 style="font-weight: bold; text-align: center; font-size: 14pt; margin-top: 1rem; text-decoration: underline;">REKAPITULASI DATA RUJUK</h4>
            <p style="text-align: center;">Bulan: {{ $namaBulan }} {{ $tahun }}</p>
            <table class="data-table" style="width: 100%; margin-top: 1rem;">
                <thead style="font-weight: bold; text-align: center;">
                    <tr>
                        <td style="width: 5%;">NO</td>
                        <td>NO. AKTA RUJUK</td>
                        <td>TANGGAL RUJUK</td>
                        <td>NAMA SUAMI</td>
                        <td>NAMA ISTRI</td>
                    </tr>
                </thead>
                <tbody>
                    {{-- Sesuaikan variabel $rekapRujuk dan nama kolomnya --}}
                    @forelse($rekapRujuk as $key => $data)
                    <tr>
                        <td style="text-align: center;">{{ $key + 1 }}</td>
                        <td>{{ $data->nomor_akta_rujuk }}</td>
                        <td style="text-align: center;">{{ \Carbon\Carbon::parse($data->tanggal_rujuk)->format('d-m-Y') }}</td>
                        <td>{{ $data->nama_suami }}</td>
                        <td>{{ $data->nama_istri }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; height: 50px;">Tidak ada data rujuk untuk periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="footer">
            <div style="width: 40%; margin-left: 60%; text-align: center;">
                <p>Pangkalan, {{ now()->isoFormat('D MMMM Y') }}</p>
                <p>Kepala</p>
                <div style="height: 70px;"></div>
                <p style="font-weight: bold; text-decoration: underline;">Marwis, S.Ag</p>
                <p>NIP. 197106172005011002</p>
            </div>
        </div>
    </div>
</body>
</html>