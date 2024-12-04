<?php

namespace App\Imports;

use App\Models\KodeBarang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KodeBarangImport implements ToModel, WithHeadingRow
{
    // Mengimpor data dari setiap baris dalam file Excel
    public function model(array $row)
    {
        return new KodeBarang([
            'kode_barang' => $row['kode_barang'],
        ]);
    }
}
