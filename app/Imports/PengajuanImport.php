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
        // Periksa apakah tanggal_ajuan adalah angka serial Excel
        if (is_numeric($row['tanggal_ajuan'])) {
            $tanggalAjuan = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_ajuan']))->format('Y-m-d');
        } else {
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

        $userLogin = Auth::user();

        // Hitung total harga
        $hargaSatuan = $row['harga_satuan'] ?? 0;
        $banyak = $row['banyak'] ?? 0;
        $totalHarga = $hargaSatuan * $banyak;

        return new Pengajuan([
            'user_id' => $userLogin->id,  // Menggunakan ID user yang login
            'barang' => $row['barang'],
            'program_kegiatan' => $row['program_kegiatan'],
            'jurusan' => $userLogin->role, // Jurusan otomatis dari user yang login
            'tanggal_ajuan' => $tanggalAjuan,
            'harga_satuan' => $hargaSatuan,
            'tahun' => $row['tahun'],
            'banyak' => $banyak,
            'total_harga' => $totalHarga, // Menggunakan hasil perhitungan
            'sumber_dana' => $row['sumber_dana'],
            'keterangan' => $row['keterangan'],
            'keperluan' => $row['keperluan'],
            'status' => 'Diajukan',
        ]);
    }
}
