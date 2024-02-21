<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;

class PengeluaranExport implements FromView, ShouldAutoSize, WithEvents, WithColumnWidths
{
    protected $view;
    protected $data;
    protected $parameter;
    protected $count;

    public function __construct($view, $data, $parameter, $count)
    {
        $this->view = $view;
        $this->data = $data;
        $this->parameter = $parameter;
        $this->count = $count;
    }

    public function view(): View
    {
        return view($this->view, [
            'data' => $this->data,
            'parameter' => $this->parameter,
            'count' => $this->count,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,        
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->mergeCells('A1:D1');
                $event->sheet->getStyle('A1:D1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $event->sheet->mergeCells('A2:D2');
                $event->sheet->getStyle('A2:D2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 13,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
