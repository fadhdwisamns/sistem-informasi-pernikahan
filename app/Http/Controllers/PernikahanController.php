<?php

namespace App\Http\Controllers;

use App\Models\Pernikahan;
use App\Models\MasterKua;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class PernikahanController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Pernikahan::with('kua');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_suami', 'like', "%{$search}%")
                  ->orWhere('nama_istri', 'like', "%{$search}%")
                  ->orWhere('no_akta', 'like', "%{$search}%");
            });
        }

        if (auth()->user()->role === 'admin' && $request->filled('kua_id')) {
            $query->where('kua_id', $request->input('kua_id'));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_akad', $request->input('bulan'));
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_akad', $request->input('tahun'));
        }

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->input('status'));
        }

        $pernikahans = $query->latest()->paginate(10)->withQueryString();

        $kuas = (auth()->user()->role === 'admin') ? MasterKua::orderBy('nama_kua')->get() : collect();

        return view('pernikahan.index', [
            'pernikahans' => $pernikahans,
            'kuas' => $kuas,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pernikahan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        // 'no_akta' => 'required|string|max:255|unique:pernikahans,no_akta',
        'tanggal_akad' => 'required',
        'nama_suami' => 'required|string|max:255',
        'nik_suami' => 'required|string|size:16',
        'tempat_lahir_suami' => 'required|string|max:255',
        'tanggal_lahir_suami' => 'required',
        'nama_istri' => 'required|string|max:255',
        'nik_istri' => 'required|string|size:16',
        'tempat_lahir_istri' => 'required|string|max:255',
        'tanggal_lahir_istri' => 'required',
    ]);

    $validated['tanggal_akad'] = Carbon::createFromFormat('d/m/Y', $request->tanggal_akad)->format('Y-m-d');
    $validated['tanggal_lahir_suami'] = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir_suami)->format('Y-m-d');
    $validated['tanggal_lahir_istri'] = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir_istri)->format('Y-m-d');
    $validated['created_by'] = auth()->id();
    $validated['kua_id'] = auth()->user()->kua_id;
    $validated['jenis_data'] = 'pernikahan'; // Asumsi default adalah pernikahan

    
    Pernikahan::create($validated);

    
    return redirect()->route('petugas-kua.pernikahan.index')
                     ->with('success', 'Data pernikahan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pernikahan $pernikahan)
    {
        return view('pernikahan.show', [
            'pernikahan' => $pernikahan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pernikahan $pernikahan)
    {
            return view('pernikahan.edit', [
            'pernikahan' => $pernikahan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pernikahan $pernikahan)
    {
        $validated = $request->validate([
        // 'no_akta' => 'required|string|max:255|unique:pernikahans,no_akta,' . $pernikahan->id,
        'tanggal_akad' => 'required|date',
        'nama_suami' => 'required|string|max:255',
        'nik_suami' => 'required|string|size:16',
        'nama_istri' => 'required|string|max:255',
        'nik_istri' => 'required|string|size:16',
        ]);

         $pernikahan->update($validated);

         return redirect()->route('petugas-kua.pernikahan.index')
                     ->with('success', 'Data pernikahan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pernikahan $pernikahan)
    {
        $pernikahan->delete();


        return redirect()->route('petugas-kua.pernikahan.index')
                        ->with('success', 'Data pernikahan berhasil dihapus.');
        }
}
