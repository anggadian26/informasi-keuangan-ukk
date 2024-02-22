<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;
// use Illuminate\View\View;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PenjualanExport implements FromView, WithColumnWidths, WithEvents
{

    protected $view;
    protected $data;
    protected $parameter;

    public function __construct($view, $data, $parameter)
    {
        $this->view = $view;
        $this->data = $data;
        $this->parameter = $parameter;
    }

    public function view(): View
    {
        return view($this->view, [
            'data' => $this->data,
            'parameter' => $this->parameter,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 20,
            'c' => 25,
            'D' => 15,
            'E' => 10,
            'F' => 25,
            'G' => 15,
            'H' => 20            
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->mergeCells('A1:H1');
                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $event->sheet->mergeCells('A2:H2');
                $event->sheet->getStyle('A2:H2')->applyFromArray([
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
