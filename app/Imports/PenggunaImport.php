<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Master\Pengguna;
use App\Models\Master\Jabatan;
use App\Models\Master\Desa;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PenggunaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        \Illuminate\Support\Facades\Log::info('Row excel: ', $row);

        if (!isset($row['username']) || !isset($row['password']) || !isset($row['nama_lengkap'])) {
            \Illuminate\Support\Facades\Log::info('Skipped due to missing username/password/nama_lengkap');
            return null; // Skip invalid rows
        }

        // Cari ID Jabatan berdasarkan nama
        $nama_jabatan = trim($row['nama_jabatan'] ?? '');
        $jabatan = $nama_jabatan ? Jabatan::where('nama_jabatan', 'LIKE', '%' . $nama_jabatan . '%')->first() : null;
        $id_jabatan = $jabatan ? $jabatan->id_jabatan : null;

        // Cari ID Desa berdasarkan nama
        $nama_desa = trim($row['nama_desa'] ?? '');
        $desa = $nama_desa ? Desa::where('nama_desa', 'LIKE', '%' . $nama_desa . '%')->first() : null;
        $id_desa = $desa ? $desa->id_desa : null;

        $pengguna = new Pengguna();
        $pengguna->id_user = Str::uuid();
        $pengguna->username = $row['username'];
        $pengguna->password = Hash::make($row['password']);
        $pengguna->nama_lengkap = $row['nama_lengkap'];
        $pengguna->role = 1;
        $pengguna->aktif = 1;
        $pengguna->id_jabatan = $id_jabatan;
        $pengguna->id_desa = $id_desa;
        $pengguna->created_by = session('id_user') ?? 'system';
        $pengguna->updated_by = session('id_user') ?? 'system';

        return $pengguna;
    }
}
