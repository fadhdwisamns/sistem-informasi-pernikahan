<?php

namespace App\Http\Controllers;

use App\Models\Pernikahan;
use App\Models\Rujuk;
use App\Models\Perceraian;
use App\Models\MasterKua; 
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use PDF;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman filter laporan.
     */
    public function index()
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = Carbon::create()->month($i)->translatedFormat('F');
        }
        $years = range(date('Y') - 5, date('Y'));

        $kuas = collect();
        if (Auth::user()->role === 'admin') {
            $kuas = MasterKua::orderBy('nama_kua')->get();
        }
        
        // Di view index, kita perlu menambahkan pilihan untuk mencetak laporan perceraian
        return view('laporan.index', compact('months', 'years', 'kuas'));
    }

    /**
     * Mengambil data dan menampilkan halaman preview laporan yang siap cetak (TANPA PERCERAIAN).
     */
    public function show(Request $request)
    {
        // 1. Validasi dan pengambilan data dasar dari request
        $user = Auth::user();
        $rules = [
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer',
        ];
        if ($user->role === 'admin') {
            $rules['kua_id'] = 'required|exists:master_kua,id';
        }
        $validated = $request->validate($rules);
        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];
        
        $kua = ($user->role === 'admin') ? MasterKua::find($validated['kua_id']) : $user->kua;
        if (!$kua) {
            return redirect()->back()->with('error', 'Data KUA tidak ditemukan.');
        }
        
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');

        // 2. Kumpulkan semua data yang dibutuhkan (kecuali perceraian)
        $data = [
            'kua' => $kua,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => $namaBulan,
            'rekapDaftarNikah' => Pernikahan::where('kua_id', $kua->id)->whereMonth('tanggal_akad', $bulan)->whereYear('tanggal_akad', $tahun)->orderBy('tanggal_daftar', 'asc')->get(),
            'rekapRujuk' => Rujuk::where('kua_id', $kua->id)->whereMonth('tanggal_rujuk', $bulan)->whereYear('tanggal_rujuk', $tahun)->get(),
        ];

        // 3. Logika untuk membuat dan menggabungkan PDF
        $pdf1 = PDF::loadView('laporan.halaman.1_surat_pengantar', $data)->setPaper('a4', 'portrait');
        $pdf2 = PDF::loadView('laporan.halaman.2_rekap_nikah', $data)->setPaper('a4', 'landscape');
        $pdf4 = PDF::loadView('laporan.halaman.4_usia_pengantin', $data)->setPaper('a4', 'landscape');

        $merger = PDFMerger::init();
        $merger->addString($pdf1->output());
        $merger->addString($pdf2->output());
        $merger->addString($pdf4->output());

        $namaFile = 'Laporan KUA ' . $kua->nama_kua . ' - ' . $namaBulan . ' ' . $tahun . '.pdf';
        
        $merger->merge();
        $kontenPdf = $merger->output();

        return response()->make(
            $kontenPdf,
            200,
            ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="'.$namaFile.'"']
        );
    }

    /**
     * FUNGSI BARU: Membuat laporan perceraian secara terpisah.
     */
    public function cetakLaporanPerceraian(Request $request)
    {
        // 1. Validasi (mirip dengan method show, tapi bisa disesuaikan jika filter berbeda)
        $user = Auth::user();
        $rules = [
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer',
        ];
        if ($user->role === 'admin') {
            $rules['kua_id'] = 'required|exists:master_kua,id';
        }
        $validated = $request->validate($rules);
        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];

        $kua = ($user->role === 'admin') ? MasterKua::find($validated['kua_id']) : $user->kua;
        if (!$kua) {
            return redirect()->back()->with('error', 'Data KUA tidak ditemukan.');
        }

        // 2. Ambil data perceraian untuk periode yang dipilih
        $rekapPerceraian = Perceraian::where('kua_id', $kua->id)
                            ->whereMonth('tanggal_putusan', $bulan)
                            ->whereYear('tanggal_putusan', $tahun)
                            ->get();

        // 3. HITUNG JUMLAH CERAI TALAK DAN GUGAT
        // Asumsi di database kolomnya 'jenis_cerai' dengan isi 'talak' atau 'gugat'
        $jumlahTalak = $rekapPerceraian->where('jenis_cerai', 'talak')->count();
        $jumlahGugat = $rekapPerceraian->where('jenis_cerai', 'gugat')->count();

        // 4. Siapkan data untuk view
        $data = [
            'kua' => $kua,
            'tahun' => $tahun,
            'namaBulan' => Carbon::create()->month($bulan)->translatedFormat('F'),
            'rekapPerceraian' => $rekapPerceraian,
            'jumlahTalak' => $jumlahTalak,
            'jumlahGugat' => $jumlahGugat,
        ];

        // 5. Render PDF dan kirim sebagai download
        $pdf = PDF::loadView('laporan.halaman.3_rekap_perceraian', $data)
                    ->setPaper('a4', 'landscape');

        $namaFile = 'Laporan Perceraian KUA ' . $kua->nama_kua . ' - ' . $data['namaBulan'] . ' ' . $tahun . '.pdf';

        return $pdf->download($namaFile);
    }
}