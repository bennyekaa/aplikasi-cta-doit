<?php

namespace App\Http\Controllers\Master\Desa;

use App\Http\Controllers\Controller;
use App\Models\Master\Desa;
use App\Models\Master\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DesaController extends Controller
{
    public function index()
    {
        $data['desa'] = Desa::with('kecamatan')->orderBy('kode_desa')->orderBy('nama_desa')->get();
        return view('master.desa.index', $data);
    }

    public function tambah()
    {
        $data['kecamatan'] = Kecamatan::all();
        return view('master.desa.tambah', $data);
    }

    public function edit($id)
    {
        $data['desa'] = Desa::where('id_desa', $id)->first();
        $data['kecamatan'] = Kecamatan::all();
        return view('master.desa.edit', $data);
    }

    public function hapus($id)
    {
        Desa::where('id_desa', $id)->delete();
        return redirect('master/desa/index');
    }

    public function proses(Request $request)
    {
        if ($request->fungsi == 'Tambah') {
            Desa::create([
                'id_desa' => Str::uuid(),
                'id_kecamatan' => $request->id_kecamatan,
                'kode_desa' => $request->kode_desa,
                'nama_desa' => $request->nama_desa,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        } elseif ($request->fungsi == 'Edit') {
            Desa::where('id_desa', $request->id_desa)->update([
                'id_kecamatan' => $request->id_kecamatan,
                'kode_desa' => $request->kode_desa,
                'nama_desa' => $request->nama_desa,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        }
        return redirect('master/desa/index');
    }
}
