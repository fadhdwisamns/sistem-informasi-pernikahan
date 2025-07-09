<?php

namespace App\Http\Controllers;

use App\Models\Perceraian;
use App\Models\MasterPA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class PerceraianController extends Controller
{
    

    public function index()
    {
        $perceraians = Perceraian::with(['masterPa', 'createdBy', 'verifiedBy'])->latest()->get();
        
        $routePrefix = (Auth::user()->role == 'petugas_kua' ? 'petugas-kua' : 'petugas-pa');
        return view('petugas-kua.perceraian.index', compact('perceraians', 'routePrefix'));
    }

    public function create()
    {
        $masterPas = MasterPA::all();
        
        $routePrefix = (Auth::user()->role == 'petugas_kua' ? 'petugas-kua' : 'petugas-pa');

        return view('petugas-kua.perceraian.create', compact('masterPas', 'routePrefix'));
        // return view($routePrefix . '.perceraian.create', compact('masterPas', 'routePrefix'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pa_id' => 'required|exists:master_pa,id',
            'tanggal_putusan' => 'required|date',
            'nama_penggugat' => 'required|string|max:255',
            'nik_penggugat' => 'required|string|digits:16', // Tambahkan ini
            'nama_tergugat' => 'required|string|max:255',
            'nik_tergugat' => 'required|string|digits:16', 
        ]);

        $data = $request->all();
        Perceraian::create($data);

       
        $redirectPrefix = (Auth::user()->role == 'petugas_kua' ? 'petugas-kua' : 'petugas-pa');
        return redirect()->route($redirectPrefix . '.perceraians.index')
                         ->with('success', 'Data perceraian berhasil ditambahkan.');
    }

    public function show(Perceraian $perceraian)
    {
        $perceraian->load(['masterPa', 'createdBy', 'verifiedBy']);
        
        $routePrefix = (Auth::user()->role == 'petugas_kua' ? 'petugas-kua' : 'petugas-pa');
        return view('petugas-kua.perceraian.show', compact('perceraian', 'routePrefix'));
    }

    public function edit(Perceraian $perceraian)
    {
        $masterPas = MasterPA::all();
        
        $routePrefix = (Auth::user()->role == 'petugas_kua' ? 'petugas-kua' : 'petugas-pa');
        return view('petugas-kua.perceraian.edit', compact('perceraian', 'masterPas', 'routePrefix'));
    }

    public function update(Request $request, Perceraian $perceraian)
    {
        $request->validate([
            'pa_id' => 'required|exists:master_pa,id',
            'tanggal_putusan' => 'required|date',
            'nama_penggugat' => 'required|string|max:255',
            'nik_penggugat' => 'required|string|digits:16', // Tambahkan ini
            'nama_tergugat' => 'required|string|max:255',
            'nik_tergugat' => 'required|string|digits:16', 
            'status_verifikasi' => 'required|in:menunggu,disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ]);

        $data = $request->all();
        $perceraian->update($data);

       
        $redirectPrefix = (Auth::user()->role == 'petugas_kua' ? 'petugas-kua' : 'petugas-pa');
        return redirect()->route($redirectPrefix . '.perceraians.index')
                         ->with('success', 'Data perceraian berhasil diperbarui.');
    }

    public function destroy(Perceraian $perceraian)
    {
        $perceraian->delete();
       
        $redirectPrefix = (Auth::user()->role == 'petugas_kua' ? 'petugas-kua' : 'petugas-pa');
        return redirect()->route($redirectPrefix . '.perceraians.index')
                         ->with('success', 'Data perceraian berhasil dihapus.');
    }

    public function verify(Request $request, Perceraian $perceraian)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ]);

        $perceraian->status_verifikasi = $request->status_verifikasi;
        $perceraian->catatan_verifikasi = $request->catatan_verifikasi;
        $perceraian->save();

       
        $redirectPrefix = (Auth::user()->role == 'petugas_kua' ? 'petugas-kua' : 'petugas-pa');
        return redirect()->route($redirectPrefix . '.perceraians.show', $perceraian)
                         ->with('success', 'Status verifikasi data perceraian berhasil diperbarui.');
    }
}