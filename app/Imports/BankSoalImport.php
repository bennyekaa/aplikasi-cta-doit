<?php

namespace App\Imports;

use App\Models\Master\BankSoal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BankSoalImport implements ToModel, WithHeadingRow
{
    protected $id_modul;
    protected $id_tematik;

    public function __construct($id_modul, $id_tematik)
    {
        $this->id_modul = $id_modul;
        $this->id_tematik = $id_tematik;
    }

    public function model(array $row)
    {
        return new BankSoal([
            'id_modul'   => $this->id_modul,
            'id_tematik' => $this->id_tematik,
            'soal'       => $row['soal'],
            'opsi_a'     => $row['a'] ?? null,
            'opsi_b'     => $row['b'] ?? null,
            'opsi_c'     => $row['c'] ?? null,
            'opsi_d'     => $row['d'] ?? null,
            'opsi_e'     => $row['e'] ?? null,
            'kunci'      => $row['kunci'] ?? null,
            'created_by' => session('id_user') ?? 'system',
        ]);
    }
}
