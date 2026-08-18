<?php

namespace App\Http\Controllers\Master\BankSoal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\BankSoal;
use App\Imports\BankSoalImport;
use App\Exports\BankSoalTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Illuminate\Support\Facades\Log;

class BankSoalController extends Controller
{
    public function index(Request $request)
    {
        $query = BankSoal::with('modul', 'tematik');
        
        if ($request->has('filter_modul') && $request->filter_modul != '') {
            $query->where('id_modul', $request->filter_modul);
        }
        
        if ($request->has('filter_tematik') && $request->filter_tematik != '') {
            $query->where('id_tematik', $request->filter_tematik);
        }
        
        $data['soal'] = $query->orderBy('id', 'ASC')->get();
        $data['modul'] = \App\Models\Master\Modul::where('aktif', 1)->get();
        
        if ($request->has('filter_modul') && $request->filter_modul != '') {
            $data['tematik'] = \App\Models\Master\KategoriSoal::where('aktif', 1)
                                ->where('id_modul', $request->filter_modul)->get();
        } else {
            $data['tematik'] = collect();
        }
        
        $data['filter_modul'] = $request->filter_modul;
        $data['filter_tematik'] = $request->filter_tematik;
        
        session()->put('bank_soal', url()->full());
        return view('master.bank_soal.index', $data);
    }

    public function template()
    {
        return Excel::download(new BankSoalTemplateExport, 'Template_Bank_Soal.xlsx');
    }

    public function getTematikByModul($id_modul)
    {
        $tematik = \App\Models\Master\KategoriSoal::where('id_modul', $id_modul)->where('aktif', 1)->get();
        return response()->json($tematik);
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'id_modul' => 'required',
                'id_tematik' => 'required',
                'data_file' => 'required|file'
            ]);

            $file = $request->file('data_file')->getRealPath();
            Excel::import(new BankSoalImport($request->id_modul, $request->id_tematik), $file);

            return redirect(session('bank_soal'))->with('success', 'Berhasil Import Bank Soal');
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
            return redirect(session('bank_soal'))->with('error', 'Gagal Import: ' . $e->getMessage());
        }
    }

    public function hapus($id)
    {
        try {
            $soal = BankSoal::find(decrypt($id));
            if ($soal) {
                $soal->delete();
            }
            return redirect(session('bank_soal'))->with('success', 'Data Terhapus');
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
            return redirect(session('bank_soal'))->with('error', 'Gagal Hapus');
        }
    }

    public function bulkHapus(Request $request)
    {
        try {
            $ids = $request->ids;
            if ($ids && is_array($ids)) {
                BankSoal::whereIn('id', $ids)->delete();
                return redirect(session('bank_soal'))->with('success', count($ids) . ' Data Terhapus');
            }
            return redirect(session('bank_soal'))->with('error', 'Pilih data yang akan dihapus');
        } catch (Exception $e) {
            Log::info('Error bulk hapus ' . $e->getMessage());
            return redirect(session('bank_soal'))->with('error', 'Gagal Hapus Data: ' . $e->getMessage());
        }
    }

}
