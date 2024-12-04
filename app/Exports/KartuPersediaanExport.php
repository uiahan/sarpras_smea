<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KartuPersediaanExport implements FromView
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        // Terapkan filter jika ada
        $query = Pengajuan::query();

        if (!empty($this->filters['tanggal_awal']) && !empty($this->filters['tanggal_akhir'])) {
            $query->whereBetween('tanggal_realisasi', [$this->filters['tanggal_awal'], $this->filters['tanggal_akhir']]);
        }

        if (!empty($this->filters['kode_barang'])) {
            $query->where('kode_barang', $this->filters['kode_barang']);
        }

        if (!empty($this->filters['nama_barang'])) {
            $query->where('nama_barang', 'like', '%' . $this->filters['nama_barang'] . '%');
        }

        $pengajuan = $query->get();

        // Kirim data ke view untuk di-export
        return view('exports.kartu_persediaan', [
            'pengajuan' => $pengajuan
        ]);
    }
}
