<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = \App\Models\Pengaturan::first();
        if (!$pengaturan) {
            $pengaturan = new \App\Models\Pengaturan();
        }
        return view('pengaturan.index', compact('pengaturan'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'instansi' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'font_type' => 'nullable|string|max:100',
            'font_size' => 'nullable|string|max:50',
        ]);

        $pengaturan = \App\Models\Pengaturan::first();
        if (!$pengaturan) {
            $pengaturan = new \App\Models\Pengaturan();
            $pengaturan->id_pengaturan = 1;
        }

        $pengaturan->instansi = $request->instansi;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/logo'), $filename);
            
            // Delete old logo if exists
            if ($pengaturan->logo && file_exists(public_path('uploads/logo/' . $pengaturan->logo))) {
                unlink(public_path('uploads/logo/' . $pengaturan->logo));
            }
            
            $pengaturan->logo = $filename;
        }

        $pengaturan->font_type = $request->font_type;
        $pengaturan->font_size = $request->font_size;

        $pengaturan->save();

        if (session()->has('login')) {
            session([
                'instansi' => $pengaturan->instansi,
                'logo' => $pengaturan->logo,
                'font_type' => $pengaturan->font_type,
                'font_size' => $pengaturan->font_size,
            ]);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
