<?php

namespace App\Http\Controllers;

use App\Models\Pernikahan;
use App\Models\Rujuk;
use App\Models\Perceraian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan role user

class LaporanController extends Controller
{
    

    public function index(Request $request)
    {
        // Mendapatkan data ringkasan atau detail berdasarkan filter
        // Anda bisa tambahkan filter seperti tanggal, KUA ID, PA ID, dll.
        
        $totalPernikahan = Pernikahan::count();
        $totalRujuk = Rujuk::count();
        $totalPerceraian = Perceraian::count();

        // Data yang menunggu verifikasi (jika ingin ditampilkan di laporan ringkasan)
        $pendingPernikahan = Pernikahan::where('status_verifikasi', 'menunggu')->count();
        $pendingRujuk = Rujuk::where('status', 'Menunggu')->count();
        $pendingPerceraian = Perceraian::where('status_verifikasi', 'menunggu')->count();

        // Anda bisa tambahkan logika filter yang lebih kompleks di sini
        // Contoh: filter berdasarkan bulan/tahun
        $selectedMonth = $request->input('bulan', date('m'));
        $selectedYear = $request->input('tahun', date('Y'));

        $laporanPernikahanBulanIni = Pernikahan::whereMonth('tanggal_akad', $selectedMonth)
                                            ->whereYear('tanggal_akad', $selectedYear)
                                            ->count();

        $laporanRujukBulanIni = Rujuk::whereMonth('tanggal_rujuk', $selectedMonth)
                                    ->whereYear('tanggal_rujuk', $selectedYear)
                                    ->count();

        $laporanPerceraianBulanIni = Perceraian::whereMonth('tanggal_putusan', $selectedMonth)
                                                ->whereYear('tanggal_putusan', $selectedYear)
                                                ->count();
        
        // Data filter untuk view
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
        }
        $years = range(date('Y') - 5, date('Y') + 1); // 5 tahun ke belakang, 1 tahun ke depan

        return view('laporan.index', compact(
            'totalPernikahan',
            'totalRujuk',
            'totalPerceraian',
            'pendingPernikahan',
            'pendingRujuk',
            'pendingPerceraian',
            'laporanPernikahanBulanIni',
            'laporanRujukBulanIni',
            'laporanPerceraianBulanIni',
            'selectedMonth',
            'selectedYear',
            'months',
            'years'
        ));
    }

}