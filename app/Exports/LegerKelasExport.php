<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LegerKelasExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $kelas;
    protected $semester;
    protected $mataPelajarans;
    protected $legerData;

    public function __construct($kelas, $semester, $mataPelajarans, $legerData)
    {
        $this->kelas = $kelas;
        $this->semester = $semester;
        $this->mataPelajarans = $mataPelajarans;
        $this->legerData = $legerData;
    }

    public function collection()
    {
        $data = collect();

        foreach ($this->legerData as $index => $siswa) {
            $row = [
                $index + 1, // No
                $siswa['nama'], // Nama Siswa
            ];

            // Add grades for each subject
            foreach ($this->mataPelajarans as $mapel) {
                $nilai = $siswa['grades'][$mapel->id] ?? null;
                $row[] = ($nilai !== null && $nilai > 0) ? $nilai : '-';
            }

            // Add total, average and ranking
            $row[] = $siswa['total'] > 0 ? $siswa['total'] : '-';
            $row[] = $siswa['average'] > 0 ? $siswa['average'] : '-';
            $row[] = $siswa['ranking'];

            $data->push($row);
        }

        return $data;
    }

    public function headings(): array
    {
        $headings = ['No', 'Nama Siswa'];

        // Add subject names
        foreach ($this->mataPelajarans as $mapel) {
            $headings[] = $mapel->nama;
        }

        // Add total, average and ranking
        $headings[] = 'Jumlah';
        $headings[] = 'Rata-rata';
        $headings[] = 'Ranking';

        return $headings;
    }

    public function styles(Worksheet $sheet)
    {
        // Add title rows
        $sheet->insertNewRowBefore(1, 3);
        
        $sheet->setCellValue('A1', 'LEGER KELAS');
        $sheet->setCellValue('A2', 'Kelas: ' . $this->kelas->nama . ' - ' . $this->kelas->tahunAjaran->tahun);
        $sheet->setCellValue('A3', 'Semester: ' . $this->semester->nama);

        // Merge title cells
        $lastColumn = $this->getLastColumn();
        $sheet->mergeCells('A1:' . $lastColumn . '1');
        $sheet->mergeCells('A2:' . $lastColumn . '2');
        $sheet->mergeCells('A3:' . $lastColumn . '3');

        // Style title
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A2:A3')->applyFromArray([
            'font' => [
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Style header row (row 4)
        $sheet->getStyle('A4:' . $lastColumn . '4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Style data rows
        $lastRow = count($this->legerData) + 4;
        $sheet->getStyle('A4:' . $lastColumn . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Center align No, grades, average, and ranking columns
        $sheet->getStyle('A5:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Center align all grade columns, average, and ranking
        $gradeStartCol = 'C';
        $sheet->getStyle($gradeStartCol . '5:' . $lastColumn . $lastRow)
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 5,  // No
            'B' => 30, // Nama Siswa
        ];

        // Subject columns
        $column = 'C';
        foreach ($this->mataPelajarans as $mapel) {
            $widths[$column] = 15;
            $column++;
        }

        // Jumlah, Average and Ranking
        $widths[$column] = 10; // Jumlah
        $column++;
        $widths[$column] = 12; // Rata-rata
        $column++;
        $widths[$column] = 10; // Ranking

        return $widths;
    }

    public function title(): string
    {
        return 'Leger Kelas';
    }

    private function getLastColumn()
    {
        // Calculate last column letter based on number of subjects + 5 (No, Nama, Jumlah, Rata-rata, Ranking)
        $totalColumns = count($this->mataPelajarans) + 5;
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($totalColumns);
    }
}
