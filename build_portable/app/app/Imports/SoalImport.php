<?php

namespace App\Imports;

use App\Models\Master\Jawaban;
use App\Models\Master\KategoriSoal;
use App\Models\Master\Soal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Str;
use Session;

class SoalImport implements ToModel
{

    private $kategori; // Deklarasikan properti $id_kategori

    public function __construct($kategori)
    {
        $this->kategori = $kategori;
    }

    public function model(array $row)
    {

        // $id_soal = Str::uuid();
        $created_by = session('id_user');
        // $gambarPath = $this->unggahGambar($row[3]);

        
        Soal::create([
            'id_soal' => Str::uuid(),
            'id_kategori_soal' => $this->kategori,
            'soal' => $row[0],
            'pembahasan' => $row[1],
            'jawaban_a' => $row[2],
            'poin_a' => $row[3],
            'jawaban_b' => $row[4],
            'poin_b' => $row[5],
            'jawaban_c' => $row[6],
            'poin_c' => $row[7],
            'jawaban_d' => $row[8],
            'poin_d' => $row[9],
            'jawaban_e' => $row[10],
            'poin_e' => $row[11],
            'created_at' => now(),
            'created_by' => $created_by
        ]);



    }

    //

    // private function unggahGambar($gambar)
    // {
    //     // Anda perlu mengimplementasikan logika unggah gambar Anda di sini,
    //     // seperti menyimpannya ke direktori tertentu dan mengembalikan pathnya.

    //     // Misalnya, jika Anda ingin mengunggah gambar ke direktori 'public/berkas':
    //     $direktori = 'public/berkas';

    //     // Generate a unique filename (optional)
    //     $namaFile = uniqid() . '.' . $gambar->getClientOriginalExtension();

    //     // Upload the image to the specified storage directory
    //     $path = Storage::putFileAs($direktori, $gambar, $namaFile);

    //     // Kembalikan path lengkap ke gambar yang telah diunggah
    //     return $path;
    // }

}
