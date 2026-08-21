<?php

namespace App\Http\Controllers\Master\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Master\Kecamatan;
use App\Models\Master\Kabupaten;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KecamatanController extends Controller
{
    public function index()
    {
        $data['kecamatan'] = Kecamatan::orderBy('kode_kecamatan')->orderBy('nama_kecamatan')->get();
        return view('master.kecamatan.index', $data);
    }

    public function tambah()
    {
        return view('master.kecamatan.tambah');
    }

    public function edit($id)
    {
        $data['kecamatan'] = Kecamatan::where('id_kecamatan', $id)->first();
        return view('master.kecamatan.edit', $data);
    }

    public function hapus($id)
    {
        Kecamatan::where('id_kecamatan', $id)->delete();
        return redirect('master/kecamatan/index');
    }

    public function proses(Request $request)
    {
        if ($request->fungsi == 'Tambah') {
            Kecamatan::create([
                'id_kecamatan' => Str::uuid(),
                'kode_kecamatan' => $request->kode_kecamatan,
                'nama_kecamatan' => $request->nama_kecamatan,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        } elseif ($request->fungsi == 'Edit') {
            Kecamatan::where('id_kecamatan', $request->id_kecamatan)->update([
                'kode_kecamatan' => $request->kode_kecamatan,
                'nama_kecamatan' => $request->nama_kecamatan,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        }
        return redirect('master/kecamatan/index');
    }
}
