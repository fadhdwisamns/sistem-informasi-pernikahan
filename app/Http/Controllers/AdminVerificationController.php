<?php

namespace App\Http\Controllers;

use App\Models\Pernikahan;
use App\Models\Rujuk;
use App\Models\Perceraian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminVerificationController extends Controller
{
    public function __construct()
    {
        // Hanya Admin yang bisa mengakses controller ini
        $this->middleware('role:admin');
    }

    public function index()
    {
        // Ambil data dari masing-masing modul yang statusnya 'menunggu'
        // Sesuaikan nama kolom status dan nilai 'menunggu' sesuai migrasi/model Anda
        $pendingPernikahans = Pernikahan::where('status_verifikasi', 'menunggu')->get();
        $pendingRujuks = Rujuk::where('status', 'Menunggu')->get(); // 'Menunggu' dengan M kapital di Rujuk
        $pendingPerceraians = Perceraian::with(['masterPa', 'createdBy', 'verifiedBy'])
                                        ->where('status_verifikasi', 'menunggu')
                                        ->get();

        return view('admin.verification.index', compact(
            'pendingPernikahans',
            'pendingRujuks',
            'pendingPerceraians'
        ));
    }

    // --- Method untuk Menampilkan Form Verifikasi Pernikahan (dipanggil dari dashboard verifikasi admin) ---
    public function showPernikahanVerificationForm(Pernikahan $pernikahan)
    {
        return view('admin.verification.pernikahan', compact('pernikahan'));
    }

    // --- Method untuk Memproses Verifikasi Pernikahan (dipanggil dari form verifikasi admin) ---
    public function verifyPernikahan(Request $request, Pernikahan $pernikahan)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:menunggu,disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ]);

        $pernikahan->status_verifikasi = $request->status_verifikasi;
        $pernikahan->catatan_verifikasi = $request->catatan_verifikasi;
        // verified_by akan diisi otomatis oleh Model Event 'updating' di Pernikahan.php
        $pernikahan->save();

        return redirect()->route('admin.verification.index')
                         ->with('success', 'Status verifikasi data pernikahan berhasil diperbarui.');
    }

    // --- Method untuk Menampilkan Form Verifikasi Rujuk (dipanggil dari dashboard verifikasi admin) ---
    public function showRujukVerificationForm(Rujuk $rujuk)
    {
        return view('admin.verification.rujuk', compact('rujuk'));
    }

    public function verifyRujuk(Request $request, Rujuk $rujuk)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Ditolak', 
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ]);

        $rujuk->status = $request->status;
        $rujuk->catatan_verifikasi = $request->catatan_verifikasi;
        // verified_by akan diisi otomatis oleh Model Event 'updating' di Rujuk.php
        $rujuk->save();

        return redirect()->route('admin.verification.index')
                         ->with('success', 'Status verifikasi data rujuk berhasil diperbarui.');
    }


    public function showPerceraianVerificationForm(Perceraian $perceraian)
    {
        // Pastikan relasi yang dibutuhkan sudah di-load
        $perceraian->load(['masterPa', 'createdBy']);
        return view('admin.verification.perceraian', compact('perceraian'));
    }

    public function verifyPerceraian(Request $request, Perceraian $perceraian)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:menunggu,disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ]);

        $perceraian->status_verifikasi = $request->status_verifikasi;
        $perceraian->catatan_verifikasi = $request->catatan_verifikasi;
      
        $perceraian->save();

        return redirect()->route('admin.verification.index')
                        ->with('success', 'Status verifikasi data perceraian berhasil diperbarui.');
    }
}