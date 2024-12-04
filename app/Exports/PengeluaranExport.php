<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PengeluaranExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    public function collection()
    {
        // Ambil semua data pengajuan yang sudah difilter sesuai kebutuhan
        return Pengajuan::all(); // Anda bisa menambahkan filter jika diperlukan
    }

    public function headings(): array
    {
        return [
            'NO', 'Tanggal Realisasi', 'Nomor Verif', 'Kode Barang', 'Nama Barang',
            'NUSP', 'Spesifikasi Nama Barang', 'Jumlah', 'Satuan Barang', 'Harga Satuan Barang',
            'Total Harga', 'Tanggal Realisasi SPPB', 'Nomor Permintaan', 'Penerima', 'Keterangan'
        ];
    }

    public function styles($sheet)
    {
        return [
            // Styling untuk header
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Format kolom harga satuan
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Format kolom total harga
        ];
    }
}

