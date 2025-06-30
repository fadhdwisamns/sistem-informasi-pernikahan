<?php

namespace App\Http\Controllers;

use App\Models\Pernikahan;
use App\Models\MasterKua;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage;
use App\Models\PernikahanFile;   
use App\Models\PernikahanImage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PernikahanImport;
use Illuminate\Support\Facades\Validator;

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
            'tanggal_daftar' => 'required|date_format:d/m/Y',
            'alamat_pasangan' => 'required|string',
            'desa' => 'required|string|max:255',
            'tempat_akad' => 'required|string|max:255',
            'wali' => 'required|string|max:255',
            'nama_wali' => 'required|string|max:255',
            'files' => 'nullable|array|max:4',
            'files.*' => 'file|mimes:pdf,doc,docx|max:2048', // max 2MB per file
            'images' => 'nullable|array|max:4',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048', // max 2MB per image
            'pendidikan_terakhir_suami' => 'nullable|string|max:255', 
        'pendidikan_terakhir_istri' => 'nullable|string|max:255'
    ]);
     DB::beginTransaction();
        try {
            // Konversi format tanggal
            $tanggalAkad = Carbon::createFromFormat('d/m/Y', $request->tanggal_akad);
            $tanggalLahirSuami = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir_suami);
            $tanggalLahirIstri = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir_istri);

            $dataToStore = $validated;
            $dataToStore['tanggal_akad'] = $tanggalAkad->format('Y-m-d');
            $dataToStore['tanggal_lahir_suami'] = $tanggalLahirSuami->format('Y-m-d');
            $dataToStore['tanggal_lahir_istri'] = $tanggalLahirIstri->format('Y-m-d');
            $dataToStore['tanggal_daftar'] = Carbon::createFromFormat('d/m/Y', $request->tanggal_daftar)->format('Y-m-d');
            
            // Hitung dan tambahkan usia
            $dataToStore['usia_suami'] = $tanggalAkad->diffInYears($tanggalLahirSuami);
            $dataToStore['usia_istri'] = $tanggalAkad->diffInYears($tanggalLahirIstri);

            // Tambahan data sistem
            $dataToStore['created_by'] = auth()->id();
            $dataToStore['kua_id'] = auth()->user()->kua_id;
            $dataToStore['jenis_data'] = 'pernikahan';

            // 1. Buat data pernikahan
            $pernikahan = Pernikahan::create($dataToStore);

            // 2. Proses upload files jika ada
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('pernikahan_files', 'public');
                    $pernikahan->files()->create([
                        'file_path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            // 3. Proses upload images jika ada
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('pernikahan_images', 'public');
                    $pernikahan->images()->create([
                        'image_path' => $path,
                        'original_name' => $image->getClientOriginalName(),
                    ]);
                }
            }

            DB::commit(); // Simpan semua perubahan jika berhasil

            return redirect()->route('petugas-kua.pernikahan.index')
                             ->with('success', 'Data pernikahan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada error
            // Optional: Hapus file yang mungkin sudah terunggah
            // ... logika untuk menghapus file ...
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan data. Terjadi kesalahan: ' . $e->getMessage())
                             ->withInput();
        }

    // $validated['tanggal_akad'] = Carbon::createFromFormat('d/m/Y', $request->tanggal_akad)->format('Y-m-d');
    // $validated['tanggal_lahir_suami'] = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir_suami)->format('Y-m-d');
    // $validated['tanggal_lahir_istri'] = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir_istri)->format('Y-m-d');
    // $validated['created_by'] = auth()->id();
    // $validated['kua_id'] = auth()->user()->kua_id;
    // $validated['jenis_data'] = 'pernikahan'; // Asumsi default adalah pernikahan

    
    // Pernikahan::create($validated);

    
    // return redirect()->route('petugas-kua.pernikahan.index')
    //                  ->with('success', 'Data pernikahan berhasil ditambahkan.');
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
            $pernikahan->load(['kua', 'files', 'images', 'createdBy', 'verifiedBy']);
            return view('pernikahan.edit', [
            'pernikahan' => $pernikahan->load(['files', 'images']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, Pernikahan $pernikahan)
    {
        // Validasi yang disesuaikan untuk method update
        $validated = $request->validate([
            // Validasi field administrasi & wali
            'tanggal_daftar' => 'required|date_format:d/m/Y',
            'tanggal_akad' => 'required|date_format:d/m/Y',
            'tempat_akad' => 'required|string|max:255',
            'wali' => 'required|string|max:255',
            'nama_wali' => 'required|string|max:255',

            // Validasi data suami
            'nama_suami' => 'required|string|max:255',
            'nik_suami' => 'required|string|size:16',
            'tempat_lahir_suami' => 'required|string|max:255',
            'tanggal_lahir_suami' => 'required|date_format:d/m/Y',

            // Validasi data istri
            'nama_istri' => 'required|string|max:255',
            'nik_istri' => 'required|string|size:16',
            'tempat_lahir_istri' => 'required|string|max:255',
            'tanggal_lahir_istri' => 'required|date_format:d/m/Y',
            
            // Validasi alamat
            'alamat_pasangan' => 'required|string',
            'desa' => 'required|string|max:255',

            // Validasi untuk file & gambar baru
            'files.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Validasi untuk item yang akan dihapus
            'delete_files' => 'nullable|array',
            'delete_files.*' => 'integer|exists:pernikahan_files,id',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:pernikahan_images,id',
            'pendidikan_terakhir_suami' => 'nullable|string|max:255', 
            'pendidikan_terakhir_istri' => 'nullable|string|max:255', 
        ]);
        
        DB::beginTransaction();
        try {
            // Hapus file/gambar yang dicentang
            if ($request->filled('delete_files')) {
                foreach ($request->delete_files as $fileId) {
                    $file = PernikahanFile::find($fileId);
                    if ($file) { Storage::disk('public')->delete($file->file_path); $file->delete(); }
                }
            }
            if ($request->filled('delete_images')) {
                foreach ($request->delete_images as $imageId) {
                    $image = PernikahanImage::find($imageId);
                    if ($image) { Storage::disk('public')->delete($image->image_path); $image->delete(); }
                }
            }

            // Siapkan data untuk diupdate
            $dataToUpdate = $request->except(['_token', '_method', 'files', 'images', 'delete_files', 'delete_images']);
            
            // Konversi format tanggal
            $tanggalAkad = Carbon::createFromFormat('d/m/Y', $request->tanggal_akad);
            $tanggalLahirSuami = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir_suami);
            $tanggalLahirIstri = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir_istri);

            $dataToUpdate['tanggal_daftar'] = Carbon::createFromFormat('d/m/Y', $request->tanggal_daftar)->format('Y-m-d');
            $dataToUpdate['tanggal_akad'] = $tanggalAkad->format('Y-m-d');
            $dataToUpdate['tanggal_lahir_suami'] = $tanggalLahirSuami->format('Y-m-d');
            $dataToUpdate['tanggal_lahir_istri'] = $tanggalLahirIstri->format('Y-m-d');

            // Hitung ulang dan update usia
            $dataToUpdate['usia_suami'] = $tanggalAkad->diffInYears($tanggalLahirSuami);
            $dataToUpdate['usia_istri'] = $tanggalAkad->diffInYears($tanggalLahirIstri);

            // Update data utama pernikahan
            $pernikahan->update($dataToUpdate);

            // Proses upload file baru jika ada
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('pernikahan_files', 'public');
                    $pernikahan->files()->create(['file_path' => $path, 'original_name' => $file->getClientOriginalName()]);
                }
            }

            // Proses upload gambar baru jika ada
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('pernikahan_images', 'public');
                    $pernikahan->images()->create(['image_path' => $path, 'original_name' => $image->getClientOriginalName()]);
                }
            }

            DB::commit();

            return redirect()->route('petugas-kua.pernikahan.index')
                             ->with('success', 'Data pernikahan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui data. Terjadi kesalahan: ' . $e->getMessage())
                             ->withInput();
        }
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
    
     public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls'
        ], [
            'file.required' => 'Anda harus memilih file untuk diunggah.',
            'file.mimes' => 'File harus dalam format .xlsx atau .xls.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'import')->withInput();
        }

        try {
            Excel::import(new PernikahanImport, $request->file('file'));
            return redirect()->route('petugas-kua.pernikahan.index')
                             ->with('success', 'Data pernikahan berhasil diimpor.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             $errors = [];
             foreach ($failures as $failure) {
                 $errors[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
             }
             return redirect()->back()->withErrors(['import' => $errors])->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Download the Excel template for importing marriage data.
     */
    public function downloadTemplate()
    {
        $path = public_path('templates/template_import_pernikahan.xlsx');
        if (!file_exists($path)) {
            // Jika file tidak ada, berikan pesan error atau buat file tersebut secara dinamis
            abort(404, 'File template tidak ditemukan.');
        }
        return response()->download($path);
    }
}
