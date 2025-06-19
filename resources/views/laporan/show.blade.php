{{-- resources/views/laporan/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulan {{ $namaBulan }} {{ $tahun }}</title>
    {{-- Kita gunakan Tailwind dari CDN agar mudah, atau gunakan app.css Anda jika sudah dikonfigurasi --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f0f0f0;
        }
        .page-container {
        width: 29.7cm;      /* <-- LEBAR LANDSCAPE */
        min-height: 21cm; /* <-- TINGGI LANDSCAPE */
        padding: 2cm;
        margin: 1rem auto;
        background: white;
        box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
        .page-break {
            page-break-after: always;
        }
        @media print {
            body {
                margin: 0;
                background-color: white;
            }
            .page-container {
                margin: 0;
                box-shadow: none;
                padding: 1.5cm;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="no-print sticky top-0 bg-gray-800 p-3 flex justify-center gap-4">
        <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Cetak Laporan
        </button>
        <a href="{{ route('laporan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Kembali ke Filter
        </a>
    </div>

    <div class="page-container">
        {{-- HALAMAN 1: SURAT PENGANTAR (CONTOH) --}}
        @include('laporan.partials.kop_surat')
        <div class="mt-4">
            {{-- Isi surat pengantar seperti di PDF --}}
            <p>Nomor: B. ... </p>
            <p>Lampiran: 1 Berkas</p>
            <p>Perihal: Laporan Bulanan</p>
            <br>
            <p>Kepada Yth;</p>
            <p>Bapak Kepala Kantor Kementerian Agama</p>
            <p>Kabupaten Kuantan Singingi</p>
            <p>di-</p>
            <p class="ml-4">Teluk Kuantan</p>
            {{-- ... dan seterusnya --}}
        </div>
        <div class="mt-8 float-right text-center">
            <p>Pangkalan, {{ now()->isoFormat('D MMMM Y') }}</p>
            <p>Kepala</p>
            <br><br><br>
            <p class="font-bold underline">Marwis, S.Ag</p>
            <p>NIP. 197106172005011002</p>
        </div>

        <div class="page-break"></div>

        {{-- HALAMAN 2: REKAPITULASI DAFTAR NIKAH --}}
        @include('laporan.partials.kop_surat')
        <h4 class="font-bold text-center text-lg mt-4 underline">REKAPITULASI DAFTAR NIKAH</h4>
        <p class="text-center">Bulan: {{ $namaBulan }} {{ $tahun }}</p>
        <table class="w-full mt-4 text-sm">
            <thead>
                <tr class="font-bold">
                    <td>NO</td>
                    <td>NAMA CALON SUAMI</td>
                    <td>NAMA CALON ISTERI</td>
                    <td>TANGGAL PENDAFTARAN</td>
                    <td>TANGGAL NIKAH</td>
                </tr>
            </thead>
            <tbody>
                @forelse($rekapDaftarNikah as $key => $data)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->nama_suami }}</td>
                    <td>{{ $data->nama_istri }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal_daftar)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal_akad)->format('d-m-Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
         <div class="mt-8 float-right text-center">
            {{-- Tanda tangan --}}
        </div>
        
       

    </div>

</body>
</html>