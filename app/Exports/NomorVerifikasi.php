<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NomorVerifikasi implements FromCollection, WithHeadings
{
    protected $pengajuan;

    public function __construct(Collection $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function collection()
    {
        return $this->pengajuan->map(function ($item) {
            return [
                'Nomor Permintaan' => $item->nomor_permintaan,
                'Nomor Verifikasi' => $item->nomor_verifikasi ?? 'Belum Dimasukan',
                'Jenis Barang' => $item->jenis_barang,
                'Status' => $item->status,
                'Tanggal Ajuan' => $item->tanggal_ajuan,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor Permintaan',
            'Nomor Verifikasi',
            'Jenis Barang',
            'Status',
            'Tanggal Ajuan',
        ];
    }
}

