<?php

namespace App\Imports;

use App\Models\DetailKodeBarang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DetailKodeBarangImport implements ToModel, WithHeadingRow
{
    protected $kode_barang_id;

    public function __construct($kode_barang_id)
    {
        $this->kode_barang_id = $kode_barang_id;
    }

    /**
     * Create a model instance from each row in the Excel file.
     */
    public function model(array $row)
    {
        return new DetailKodeBarang([
            'nusp'           => $row['nusp'], // Sesuaikan nama kolom dengan header di Excel
            'nama_barang'    => $row['nama_barang'],
            'kode_barang_id' => $this->kode_barang_id,
        ]);
    }
}
