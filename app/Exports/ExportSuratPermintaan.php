<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportSuratPermintaan implements FromCollection, WithHeadings
{
    protected $pengajuan;

    // Konstruktor untuk menerima data
    public function __construct(Collection $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    // Mengembalikan data untuk diekspor
    public function collection()
    {
        return $this->pengajuan->map(function ($item) {
            return [
                'Kode Barang' => $item->kode_barang,
                'Nama Barang' => $item->nama_barang,
                'NUSP' => $item->nusp,
                'Spesifikasi Nama Barang' => $item->barang,
                'Jumlah' => $item->banyak,
                'Satuan Barang' => $item->satuan_barang,
                'Jumlah yg di acc' => $item->jumlah_yg_diacc ?? 'Belum Dimasukan',
                'Satuan yg di acc' => $item->satuan_barang,
                'Keperluan' => $item->keperluan,
                'Keterangan' => $item->keterangan,
            ];
        });
    }

    // Mengatur header kolom
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'NUSP',
            'Spesifikasi Nama Barang',
            'Jumlah',
            'Satuan Barang',
            'Jumlah yg di acc',
            'Satuan yg di acc',
            'Keperluan',
            'Keterangan',
        ];
    }
}
