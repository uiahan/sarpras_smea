<?php

namespace App\Imports;

use App\Models\Pengajuan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PengajuanImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari pengguna berdasarkan jurusan dan role
        $currentUser = Auth::user();

        // Tentukan user_id berdasarkan role
        if ($currentUser->role === 'admin') {
            // Jika yang login adalah admin, cari user berdasarkan jurusan
            $user = User::where('role', $row['jurusan'])->first();

            if (!$user) {
                // Jika tidak ada pengguna dengan jurusan dan role yang cocok, kembalikan null atau lakukan error handling sesuai kebutuhan Anda
                return null;
            }

            $userId = $user->id;
        } else {
            // Jika yang login bukan admin, gunakan user_id dari pengguna yang sedang login
            $userId = $currentUser->id;
        }

        // Periksa apakah tanggal_ajuan adalah angka serial Excel
        if (is_numeric($row['tanggal_ajuan'])) {
            // Excel menggunakan serial number untuk tanggal (tanggal 1 = 1900-01-01)
            $tanggalAjuan = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_ajuan']))->format('Y-m-d');
        } else {
            // Jika bukan angka, maka coba parsing tanggal dalam format lain
            $tanggalAjuan = Carbon::parse($row['tanggal_ajuan'])->format('Y-m-d');
        }

        // Lakukan hal yang sama untuk tanggal_realisasi
        if (isset($row['tanggal_realisasi']) && is_numeric($row['tanggal_realisasi'])) {
            $tanggalRealisasi = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_realisasi']))->format('Y-m-d');
        } elseif (isset($row['tanggal_realisasi'])) {
            $tanggalRealisasi = Carbon::parse($row['tanggal_realisasi'])->format('Y-m-d');
        } else {
            $tanggalRealisasi = null;
        }

        return new Pengajuan([
            'user_id' => $userId,  // Menggunakan user_id dari hasil pencarian
            'barang' => $row['barang'],
            'program_kegiatan' => $row['program_kegiatan'],
            'jurusan' => $row['jurusan'],
            'tanggal_ajuan' => $tanggalAjuan,
            'tanggal_realisasi' => $tanggalRealisasi,
            'harga_satuan' => $row['harga_satuan'],
            'tahun' => $row['tahun'],
            'banyak' => $row['banyak'],
            'total_harga' => $row['total_harga'],
            'catatan' => $row['catatan'],
            'harga_beli' => $row['harga_beli'],
            'sumber_dana' => $row['sumber_dana'],
            'keterangan' => $row['keterangan'],
            'status' => $row['status'],
        ]);
    }
}
