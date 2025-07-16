{{-- resources/views/laporan/halaman/1_surat_pengantar.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Surat Pengantar</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; margin: 0; }
        .page {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            /* page-break-after: always; */
        }
        .header, .footer {
            position: absolute;
            left: 1.5cm;
            right: 1.5cm;
        }
        .header { top: 1.5cm; }
        .footer { bottom: 1.5cm; }
        .content {
            padding-top: 5.5cm;  /* Space untuk header */
            padding-left: 1.5cm;
            padding-right: 1.5cm;
        }
        .report-table, .report-table th, .report-table td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            @include('laporan.partials.kop_surat')
        </div>

        <div class="content">
            <h4 style="text-align: center; font-weight: bold; text-decoration: underline; font-size: 14pt;">SURAT PENGANTAR</h4>
            {{-- Nomor surat dinamis, kode KUA bisa Anda buat dinamis dari $kua->kode jika ada --}}
            <p style="text-align: center; margin-top: 0;">
                Nomor: B. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /Kua.04.11/15/PW.01/{{ str_pad($bulan, 2, '0', STR_PAD_LEFT) }}/{{ $tahun }}
            </p>

            <br>

            <table class="report-table" style="width: 100%;">
                <thead>
                    <tr style="font-weight: bold; text-align: center;">
                        <th style="width: 5%;">No</th>
                        <th style="width: 45%;">ISI SURAT/JENIS YANG DIKIRIM</th>
                        <th style="width: 15%;">BANYAKNYA</th>
                        <th>KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center; height: 100px;">1</td>
                        <td>Laporan Bulanan Kantor Urusan Agama Kecamatan {{ $kua->nama_kua }} Bulan {{ $namaBulan }} Tahun {{ $tahun }}</td>
                        <td style="text-align: center;">1 Berkas</td>
                        <td>Kami kirimkan untuk dapat dipergunakan seperlunya dan terima kasih.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <div style="width: 40%; margin-left: 60%; text-align: center;">
                <p>Pangkalan, {{ now()->isoFormat('D MMMM Y') }}</p>
                <p>Kepala</p>
                <div style="height: 70px;"></div>
                {{-- Data Dinamis --}}
                <p style="font-weight: bold; text-decoration: underline;">{{ $kepalaKua['nama'] }}</p>
                <p>NIP. {{ $kepalaKua['nip'] }}</p>
            </div>
        </div>
    </div>
</body>
</html>