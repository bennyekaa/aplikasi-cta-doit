<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankSoalTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'soal',
            'a',
            'b',
            'c',
            'd',
            'e',
            'kunci'
        ];
    }

    public function array(): array
    {
        return [
            [
                'Apa ibukota Indonesia?',
                'Jakarta',
                'Bandung',
                'Surabaya',
                'Medan',
                'Semarang',
                'a'
            ]
        ];
    }
}
