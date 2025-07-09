<?php

namespace App\Imports;

use App\Models\Pernikahan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class PernikahanImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Menggunakan Carbon::parse() yang lebih fleksibel untuk menangani format tanggal
        $tanggalAkad = Carbon::parse($row['tanggal_akad']);
        $tanggalLahirSuami = Carbon::parse($row['tanggal_lahir_suami']);
        $tanggalLahirIstri = Carbon::parse($row['tanggal_lahir_istri']);

        return new Pernikahan([
            // Memastikan semua tanggal disimpan dalam format Y-m-d
            'tanggal_daftar' => Carbon::parse($row['tanggal_daftar'])->format('Y-m-d'),
            'tanggal_akad' => $tanggalAkad->format('Y-m-d'),
            'tempat_akad' => $row['tempat_akad'],
            'wali' => $row['wali'],
            'nama_wali' => $row['nama_wali'],
            'nama_suami' => $row['nama_suami'],
            'nik_suami' => $row['nik_suami'],
            'tempat_lahir_suami' => $row['tempat_lahir_suami'],
            'tanggal_lahir_suami' => $tanggalLahirSuami->format('Y-m-d'),
            'usia_suami' => $tanggalAkad->diffInYears($tanggalLahirSuami),
            'pendidikan_terakhir_suami' => $row['pendidikan_terakhir_suami'],
            'nama_istri' => $row['nama_istri'],
            'nik_istri' => $row['nik_istri'],
            'tempat_lahir_istri' => $row['tempat_lahir_istri'],
            'tanggal_lahir_istri' => $tanggalLahirIstri->format('Y-m-d'),
            'usia_istri' => $tanggalAkad->diffInYears($tanggalLahirIstri),
            'pendidikan_terakhir_istri' => $row['pendidikan_terakhir_istri'],
            'alamat_pasangan' => $row['alamat_pasangan'],
            'desa' => $row['desa'],
            'kua_id' => Auth::user()->kua_id,
            'created_by' => Auth::id(),
            'jenis_data' => 'pernikahan',
            'status_verifikasi' => 'menunggu', // Default status
        ]);
    }

    public function rules(): array
    {
        return [
            // Mengubah validasi untuk menerima format tanggal YYYY-MM-DD
            '*.tanggal_daftar' => 'required|date_format:Y-m-d',
            '*.tanggal_akad' => 'required|date_format:Y-m-d',
            '*.tempat_akad' => 'required|string|max:255',
            '*.wali' => 'required|string|max:255',
            '*.nama_wali' => 'required|string|max:255',
            '*.nama_suami' => 'required|string|max:255',
            // Aturan NIK tetap untuk memastikan 16 digit angka
            '*.nik_suami' => 'required|digits:16',
            '*.tempat_lahir_suami' => 'required|string|max:255',
            '*.tanggal_lahir_suami' => 'required|date_format:Y-m-d',
            '*.pendidikan_terakhir_suami' => 'nullable|string|max:255',
            '*.nama_istri' => 'required|string|max:255',
            '*.nik_istri' => 'required|digits:16',
            '*.tempat_lahir_istri' => 'required|string|max:255',
            '*.tanggal_lahir_istri' => 'required|date_format:Y-m-d',
            '*.pendidikan_terakhir_istri' => 'nullable|string|max:255',
            '*.alamat_pasangan' => 'required|string',
            '*.desa' => 'required|string|max:255',
        ];
    }
}