<?php

namespace App\Http\Controllers;
use App\Models\Pernikahan;
use App\Models\Perceraian;
use App\Models\MasterKua; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Carbon\Carbon; 


class DashboardController extends Controller
{
     public function index(): View
    {
        $user = Auth::user();
        $viewData = [];
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Hanya siapkan data canggih ini jika rolenya admin
        if ($user->role == 'admin') {
            // 1. DATA UNTUK KARTU STATISTIK
            $viewData = [
                'pernikahan_bulan_ini' => Pernikahan::whereYear('tanggal_akad', $currentYear)->whereMonth('tanggal_akad', $currentMonth)->count(),
                'perceraian_bulan_ini' => Perceraian::whereYear('tanggal_putusan', $currentYear)->whereMonth('tanggal_putusan', $currentMonth)->count(),
                'menunggu_verifikasi' => Pernikahan::where('status_verifikasi', 'menunggu')->count() + Perceraian::where('status_verifikasi', 'menunggu')->count(),
                'total_kua' => MasterKua::count(),
            ];

            // 2. DATA UNTUK GRAFIK (CHART)
            $labels = [];
            $pernikahanData = array_fill(0, 12, 0);
            $perceraianData = array_fill(0, 12, 0);

            for ($i = 1; $i <= 12; $i++) {
                $labels[] = Carbon::create()->month($i)->format('M');
            }

            $pernikahanBulanan = Pernikahan::select(
                DB::raw('MONTH(tanggal_akad) as bulan'),
                DB::raw('COUNT(*) as jumlah')
            )->whereYear('tanggal_akad', $currentYear)->groupBy('bulan')->get();

            $perceraianBulanan = Perceraian::select(
                DB::raw('MONTH(tanggal_putusan) as bulan'),
                DB::raw('COUNT(*) as jumlah')
            )->whereYear('tanggal_putusan', $currentYear)->groupBy('bulan')->get();

            foreach ($pernikahanBulanan as $data) {
                $pernikahanData[$data->bulan - 1] = $data->jumlah;
            }
            foreach ($perceraianBulanan as $data) {
                $perceraianData[$data->bulan - 1] = $data->jumlah;
            }
            
            $viewData['chart_labels'] = $labels;
            $viewData['pernikahan_data'] = $pernikahanData;
            $viewData['perceraian_data'] = $perceraianData;

            // 3. DATA UNTUK AKTIVITAS TERBARU
            $pernikahanTerbaru = Pernikahan::select('nama_suami as pihak1', 'nama_istri as pihak2', 'created_at', DB::raw("'Pernikahan' as jenis_kegiatan"))->latest()->limit(5);
            $perceraianTerbaru = Perceraian::select('nama_penggugat as pihak1', 'nama_tergugat as pihak2', 'created_at', DB::raw("'Perceraian' as jenis_kegiatan"))->latest()->limit(5);
            
            $viewData['aktivitas_terbaru'] = $pernikahanTerbaru->union($perceraianTerbaru)->orderBy('created_at', 'desc')->limit(5)->get();

            // 4. DATA UNTUK GRAFIK RENTANG USIA
            $ageLabels = ['< 20', '20-30', '31-40', '41-50', '> 50'];
            $pernikahanAgeData = array_fill(0, 5, 0);
            $perceraianAgeData = array_fill(0, 5, 0);

            $getAgeData = function ($model, $dateColumn, $dobColumn) use ($currentYear) {
                // Fungsi ini sekarang aman karena Anda sudah menambahkan kolomnya
                return $model->select(
                    DB::raw("
                        CASE
                            WHEN (YEAR({$dateColumn}) - YEAR({$dobColumn})) < 20 THEN 0
                            WHEN (YEAR({$dateColumn}) - YEAR({$dobColumn})) BETWEEN 20 AND 30 THEN 1
                            WHEN (YEAR({$dateColumn}) - YEAR({$dobColumn})) BETWEEN 31 AND 40 THEN 2
                            WHEN (YEAR({$dateColumn}) - YEAR({$dobColumn})) BETWEEN 41 AND 50 THEN 3
                            ELSE 4
                        END as age_bracket,
                        COUNT(*) as jumlah
                    ")
                )->whereYear($dateColumn, $currentYear)
                ->whereNotNull($dobColumn)
                ->groupBy('age_bracket')->get()->pluck('jumlah', 'age_bracket');
            };

            // Data Usia Pernikahan
            $suamiAgeResult = $getAgeData(new Pernikahan, 'tanggal_akad', 'tanggal_lahir_suami');
            $istriAgeResult = $getAgeData(new Pernikahan, 'tanggal_akad', 'tanggal_lahir_istri');
            foreach ($suamiAgeResult as $bracket => $jumlah) { if(isset($pernikahanAgeData[$bracket])) $pernikahanAgeData[$bracket] += $jumlah; }
            foreach ($istriAgeResult as $bracket => $jumlah) { if(isset($pernikahanAgeData[$bracket])) $pernikahanAgeData[$bracket] += $jumlah; }
            
            // AKTIFKAN KEMBALI Data Usia Perceraian
            $penggugatAgeResult = $getAgeData(new Perceraian, 'tanggal_putusan', 'tanggal_lahir_penggugat');
            $tergugatAgeResult = $getAgeData(new Perceraian, 'tanggal_putusan', 'tanggal_lahir_tergugat');
            foreach ($penggugatAgeResult as $bracket => $jumlah) { if(isset($perceraianAgeData[$bracket])) $perceraianAgeData[$bracket] += $jumlah; }
            foreach ($tergugatAgeResult as $bracket => $jumlah) { if(isset($perceraianAgeData[$bracket])) $perceraianAgeData[$bracket] += $jumlah; }

            $viewData['age_chart_labels'] = $ageLabels;
            $viewData['pernikahan_age_data'] = $pernikahanAgeData;
            $viewData['perceraian_age_data'] = $perceraianAgeData;
        }
    
        // =======================================================
        // LOGIKA UNTUK PETUGAS KUA
        // =======================================================
        if ($user->role == 'petugas_kua') {
            $viewData = [
                'total_input_kua' => Pernikahan::where('kua_id', $user->kua_id)->count(),
                'pernikahan_disetujui' => Pernikahan::where('kua_id', $user->kua_id)->where('status_verifikasi', 'disetujui')->count(),
                'pernikahan_menunggu' => Pernikahan::where('kua_id', $user->kua_id)->where('status_verifikasi', 'menunggu')->count(),
                'pernikahan_ditolak' => Pernikahan::where('kua_id', $user->kua_id)->where('status_verifikasi', 'ditolak')->count(),
            ];

            // Data chart untuk petugas KUA
            $labels = [];
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = Carbon::create()->month($i)->format('M');
            }
            $pernikahanData = $this->getMonthlyData(new Pernikahan, 'tanggal_akad', $currentYear, 'kua_id', $user->kua_id);
            $viewData['chart_labels'] = $labels;
            $viewData['chart_datasets'] = [
                ['label' => 'Input Pernikahan & Rujuk', 'data' => $pernikahanData, 'borderColor' => 'rgba(59, 130, 246, 1)', 'backgroundColor' => 'rgba(59, 130, 246, 0.2)'],
            ];

            // Aktivitas terbaru untuk petugas KUA
            $viewData['aktivitas_terbaru'] = Pernikahan::where('kua_id', $user->kua_id)->select('nama_suami as pihak1', 'nama_istri as pihak2', 'created_at', DB::raw("'Pernikahan' as jenis_kegiatan"))->latest()->limit(5)->get();
        }

        // =======================================================
        // LOGIKA UNTUK PETUGAS PA
        // =======================================================
        if ($user->role == 'petugas_pa') {
             $viewData = [
                'total_input_pa' => Perceraian::where('pa_id', $user->pa_id)->count(),
                'perceraian_disetujui' => Perceraian::where('pa_id', $user->pa_id)->where('status_verifikasi', 'disetujui')->count(),
                'perceraian_menunggu' => Perceraian::where('pa_id', $user->pa_id)->where('status_verifikasi', 'menunggu')->count(),
                'perceraian_ditolak' => Perceraian::where('pa_id', $user->pa_id)->where('status_verifikasi', 'ditolak')->count(),
            ];

            // Data chart untuk petugas PA
            $labels = [];
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = Carbon::create()->month($i)->format('M');
            }
            $perceraianData = $this->getMonthlyData(new Perceraian, 'tanggal_putusan', $currentYear, 'pa_id', $user->pa_id);
            $viewData['chart_labels'] = $labels;
            $viewData['chart_datasets'] = [
                ['label' => 'Input Perceraian', 'data' => $perceraianData, 'borderColor' => 'rgba(239, 68, 68, 1)', 'backgroundColor' => 'rgba(239, 68, 68, 0.2)'],
            ];

            // Aktivitas terbaru untuk petugas PA
            $viewData['aktivitas_terbaru'] = Perceraian::where('pa_id', $user->pa_id)->select('nama_penggugat as pihak1', 'nama_tergugat as pihak2', 'created_at', DB::raw("'Perceraian' as jenis_kegiatan"))->latest()->limit(5)->get();
        }

        return view('dashboard', $viewData);
    }
    
    /**
     * Helper function untuk mengambil data bulanan untuk chart.
     */
    private function getMonthlyData($model, $dateColumn, $year, $filterKey = null, $filterValue = null)
    {
        $data = array_fill(0, 12, 0);

        $query = $model->select(
            DB::raw("MONTH({$dateColumn}) as bulan"),
            DB::raw('COUNT(*) as jumlah')
        )->whereYear($dateColumn, $year);
        
        if($filterKey && $filterValue) {
            $query->where($filterKey, $filterValue);
        }
        
        $results = $query->groupBy('bulan')->get();

        foreach ($results as $result) {
            $data[$result->bulan - 1] = $result->jumlah;
        }

        return $data;
    }
}