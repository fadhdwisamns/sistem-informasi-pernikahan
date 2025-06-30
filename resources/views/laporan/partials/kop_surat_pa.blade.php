{{-- resources/views/laporan/partials/kop_surat_pa.blade.php --}}
<div class="kop-surat">
    <table style="width: 100%; border: none;">
        <tr style="border: none;">
            <td style="width: 20%; text-align: center; border: none; vertical-align: middle;">
                {{-- Ganti dengan logo Pengadilan Agama jika ada --}}
                <img src="{{ public_path('images/logo-kemenag.png') }}" alt="Logo" style="width: 90px; height: 90px;">
            </td>
            <td style="width: 80%; text-align: center; border: none; vertical-align: middle;">
                <h4 style="font-weight: bold; font-size: 16pt; margin: 0;">PENGADILAN AGAMA</h4>
                <h5 style="font-weight: bold; font-size: 14pt; margin: 0;">DAERAH KABUPATEN KUANTAN SINGINGI</h5>
                {{-- Sesuaikan alamat jika berbeda --}}
                <p style="font-size: 11pt; margin: 0;">Alamat: Jl. Raya Kuantan Singingi Kode Pos 12345</p>
            </td>
        </tr>
    </table>
    <hr style="border-top: 4px solid black; margin-top: 8px; margin-bottom: 8px;">
</div>