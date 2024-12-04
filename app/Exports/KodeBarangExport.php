<?php

namespace App\Exports;

use App\Models\KodeBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\Border;

class KodeBarangExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize, WithColumnFormatting
{
    public function collection()
    {
        // Ambil data kode barang dari database
        return KodeBarang::all(['kode_barang']);
    }

    public function headings(): array
    {
        // Menambahkan heading untuk kolom Excel
        return [
            ['Kode Barang'],
        ];
    }

    public function styles($sheet)
    {
        // Menambahkan border dan styling
        $sheet->getStyle('A1:A' . $sheet->getHighestRow())
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);

        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        // Judul untuk sheet
        return 'Kode Barang';
    }

    public function columnFormats(): array
    {
        // Format kolom jika diperlukan
        return [
            'A' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT,
        ];
    }
}
