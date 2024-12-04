<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengajuanExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell
{
    public function collection()
    {
        return Pengajuan::select([
            'barang',
            'program_kegiatan',
            'jurusan',
            'tanggal_ajuan',
            'tanggal_realisasi',
            'harga_satuan',
            'tahun',
            'banyak',
            'total_harga',
            'harga_beli',
            'sumber_dana',
            'keterangan',
            'status',
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Barang',
            'Program Kegiatan',
            'Jurusan',
            'Tanggal Ajuan',
            'Tanggal Realisasi',
            'Harga Satuan',
            'Tahun',
            'Banyak',
            'Total Harga',
            'Harga Beli',
            'Sumber Dana',
            'Keterangan',
            'Status',
        ];
    }

    // Menentukan sel awal untuk tabel
    public function startCell(): string
    {
        return 'A3'; // Tabel dimulai dari baris ke-3
    }

    public function styles(Worksheet $sheet)
    {
        // Menambahkan judul di baris pertama
        $sheet->setCellValue('A1', 'Data Pengajuan');
        $sheet->mergeCells('A1:M1'); // Merge judul agar berada di tengah
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Set border untuk tabel
        $sheet->getStyle('A3:M' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Set style untuk header tabel
        $sheet->getStyle('A3:M3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        return $sheet;
    }
}
