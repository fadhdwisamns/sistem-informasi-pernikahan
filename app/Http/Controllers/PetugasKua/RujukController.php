<?php

namespace App\Http\Controllers\PetugasKua;

use App\Http\Controllers\Controller;
use App\Models\Rujuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class RujukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rujuks = Rujuk::latest()->get();
         return view('petugas-kua.rujuk.index', compact('rujuks'));
    }

    public function create()
    {
        return view('petugas-kua.rujuk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'no_surat_rujuk' => 'required|unique:rujuks',
            'tanggal_rujuk' => 'required|date',
            'nama_suami' => 'required|string',
            'nik_suami' => 'required|string',
            'nama_istri' => 'required|string',
            'nik_istri' => 'required|string',
            'tempat_rujuk' => 'required|string',
            'file_akta_cerai' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048', // Tambahkan validasi file
        ]);

        // $data = $request->except('no_surat_rujuk'); 
        $data = $request->except(['_token', 'file_akta_cerai']);

        if ($request->hasFile('file_akta_cerai')) {
            $path = $request->file('file_akta_cerai')->store('akta_cerai_rujuk', 'public');
            $data['file_akta_cerai'] = $path;
        }

        Rujuk::create($data);

        return redirect()->route('petugas-kua.rujuk.index')
                         ->with('success', 'Data rujuk berhasil ditambahkan.');
    }

    public function show(Rujuk $rujuk)
    {
        return view('petugas-kua.rujuk.show', compact('rujuk'));
    }

    public function edit(Rujuk $rujuk)
    {
        return view('petugas-kua.rujuk.edit', compact('rujuk'));
    }

    public function update(Request $request, Rujuk $rujuk)
    {
        $validated = $request->validate([
            // 'no_surat_rujuk' => 'required|unique:rujuks,no_surat_rujuk,' . $rujuk->id,
            'tanggal_rujuk' => 'required|date',
            'nama_suami' => 'required|string',
            'nik_suami' => 'required|string',
            'nama_istri' => 'required|string',
            'nik_istri' => 'required|string',
            'tempat_rujuk' => 'required|string',
            'status' => 'required|in:Menunggu,Disetujui,Ditolak',
            'desa' => 'required|string|max:255', 
            'file_akta_cerai' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);
         if ($request->hasFile('file_akta_cerai')) {
            // Hapus file lama jika ada
            if ($rujuk->file_akta_cerai) {
                Storage::disk('public')->delete($rujuk->file_akta_cerai);
            }
            // Simpan file baru
            $path = $request->file('file_akta_cerai')->store('akta_cerai_rujuk', 'public');
            $validated['file_akta_cerai'] = $path;
        }
        $rujuk->update($validated);

        return redirect()->route('petugas-kua.rujuk.index')
                         ->with('success', 'Data rujuk berhasil diperbarui.');
    }

    public function destroy(Rujuk $rujuk)
    {
        $rujuk->delete();
        return redirect()->route('petugas-kua.rujuk.index')
                         ->with('success', 'Data rujuk berhasil dihapus.');
    }
}
