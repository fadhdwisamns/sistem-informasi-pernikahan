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
        
        return view('laporan.index', compact('months', 'years', 'kuas'));
    }

    /**
     * Mengambil data dan menampilkan halaman preview laporan yang siap cetak.
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
        
        // Tentukan KUA berdasarkan user yang login atau pilihan admin
        $kua = ($user->role === 'admin') ? MasterKua::find($validated['kua_id']) : $user->kua;
        if (!$kua) {
            return redirect()->back()->with('error', 'Data KUA tidak ditemukan.');
        }
        
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');

        // 2. Kumpulkan semua data yang dibutuhkan oleh view
        $data = [
            'kua' => $kua,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => $namaBulan,
            'rekapDaftarNikah' => Pernikahan::where('kua_id', $kua->id)->whereMonth('tanggal_akad', $bulan)->whereYear('tanggal_akad', $tahun)->orderBy('tanggal_daftar', 'asc')->get(),
            
            // Ambil data perceraian dan rujuk yang SUDAH memiliki kua_id yang sama
            
            'rekapPerceraian' => Perceraian::where('kua_id', $kua->id)->whereMonth('tanggal_putusan', $bulan)->whereYear('tanggal_putusan', $tahun)->get(),
            'rekapRujuk' => Rujuk::where('kua_id', $kua->id)->whereMonth('tanggal_rujuk', $bulan)->whereYear('tanggal_rujuk', $tahun)->get(),
        ];

        // 3. Logika untuk membuat dan menggabungkan PDF
        
        // Render Halaman 1 (Portrait) - Surat Pengantar
        $pdf1 = PDF::loadView('laporan.halaman.1_surat_pengantar', $data)
                    ->setPaper('a4', 'portrait');

        // Render Halaman 2 (Landscape) - Rekap Nikah
        $pdf2 = PDF::loadView('laporan.halaman.2_rekap_nikah', $data)
                    ->setPaper('a4', 'landscape');
        
        // Render Halaman 3 (Landscape) - Rekap Perceraian
        $pdf3 = PDF::loadView('laporan.halaman.3_rekap_perceraian', $data)
                    ->setPaper('a4', 'landscape');

        // Render Halaman 4 (Landscape) - Rekap Rujuk
        $pdf4 = PDF::loadView('laporan.halaman.4_usia_pengantin', $data) // Ganti nama view di sini
            ->setPaper('a4', 'landscape');

        // Inisialisasi PDF Merger
        $merger = PDFMerger::init();

        // Tambahkan semua PDF yang sudah dirender ke merger
        $merger->addString($pdf1->output());
        $merger->addString($pdf2->output());
        $merger->addString($pdf3->output());
        $merger->addString($pdf4->output());

        // Buat nama file yang dinamis
        $namaFile = 'Laporan KUA ' . $kua->nama_kua . ' - ' . $namaBulan . ' ' . $tahun . '.pdf';
        
        // Gabungkan semua PDF menjadi satu
        $merger->merge();
        
        // Dapatkan konten mentah dari PDF yang sudah digabung
        $kontenPdf = $merger->output();

        // Kirim response unduhan ke browser
        return response()->make(
            $kontenPdf,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$namaFile.'"'
            ]
        );
    }
}