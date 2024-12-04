<?php

namespace App\Exports;

use App\Models\DetailKodeBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetailKodeBarangExport implements FromCollection, WithHeadings
{
    protected $kode_barang_id;

    /**
     * Constructor to receive kode_barang_id.
     */
    public function __construct($kode_barang_id)
    {
        $this->kode_barang_id = $kode_barang_id;
    }

    /**
     * Return a collection of data filtered by kode_barang_id.
     */
    public function collection()
    {
        return DetailKodeBarang::where('kode_barang_id', $this->kode_barang_id)
            ->select('nusp', 'nama_barang')
            ->get();
    }

    /**
     * Return the column headings for the export.
     */
    public function headings(): array
    {
        return [
            'NUSP',
            'Nama Barang',
        ];
    }
}
