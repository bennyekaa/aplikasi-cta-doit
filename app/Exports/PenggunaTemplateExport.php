<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class PenggunaTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'Username',
            'Password',
            'Nama Lengkap',
            'Nama Jabatan',
            'Nama Desa'
        ];
    }
}
