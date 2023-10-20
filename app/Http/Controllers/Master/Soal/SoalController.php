<?php

namespace App\Http\Controllers\Master\Soal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\SoalImport;
use App\Models\Master\KategoriSoal;
use App\Models\Master\Modul;
use App\Models\Master\Soal;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SoalController extends Controller
{
    public function index(){
        $data['soal'] = Soal::all();
        session()->put('soal', url()->full());
        return view('master.soal.index', $data);
    }

    public function list(){
        $data['kategori'] = KategoriSoal::where('aktif', 1)->orderBy('created_at', 'DESC')->get();
        session()->put('list_soal', url()->full());
        return view('master.soal.list', $data);
    }

    public function detail_list($id){
        $data['id'] = decrypt($id);
        $data['kategori'] = KategoriSoal::find(decrypt($id));
        $data['detail_soal'] = Soal::join('ref_kategori', 'ref_kategori.id_kategori', '=', 'ref_soal.id_kategori')->join('ref_modul', 'ref_modul.id_modul', '=', 'ref_soal.id_modul')->where('ref_soal.id_kategori', decrypt($id))->orderBy('ref_soal.created_at', 'DESC')->get();
        session()->put('detail_soal', url()->full());
        return view('master.soal.detail_list', $data);
    }

    public function add($id){
        $data['id_kategori'] = $id;
        $data['modul'] = Modul::where('aktif', 1)->get();
        return view('master.soal.add',$data);
    }

    public function add_detail($id){

    }

    public function hapus($id){
        try {
            $berkas = Soal::find(decrypt($id));
            Storage::delete($berkas->soal);
            Storage::delete($berkas->pembahasan);
            $berkas->delete();
            return redirect(session('detail_soal'))->with('success', 'Data Terhapus');
            // dd($data);
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
            return redirect(session('detail_soal'));
        }
    }

    public function proses(Request $request){
        try {
            // dd($request->all());
            $soal_upl = null;
            $pembahasan_upl = null;
            if(!empty($request->soal)){
                $soal_upl = Storage::putFile('/public/berkas', $request->soal);
            }
            if(!empty($request->pembahasan)){
                $pembahasan_upl = Storage::putFile('/public/berkas', $request->pembahasan);
            }
            if($request->fungsi == 'Tambah'){
                $soal = new Soal();
                $soal->id_kategori = decrypt($request->id_kategori);
                $soal->id_modul = $request->id_modul;
                $soal->soal = $soal_upl;
                $soal->pembahasan = $pembahasan_upl;
                $soal->nomor = $request->nomor;
                $soal->poin_a = $request->poin_a;
                $soal->poin_b = $request->poin_b;
                $soal->poin_c = $request->poin_c;
                $soal->poin_d = $request->poin_d;
                $soal->poin_e = $request->poin_e;
                $soal->created_at = $this->waktu;
                $soal->created_by = session('id_user');
                $soal->save();
                return redirect(session('detail_soal'))->with('success', 'Berhasil Tambah');
            }
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        try{
            // dd($request->all());
            // try {

            // linux
            // $path1 = $request->file('data_file')->store('temp');
            // $path = storage_path('app') . '/' . $path1;
            // \Excel::import(new DesaImport, $path);
            $kategori = $request->kategori;
            $file = $request->file('data_file')->getRealPath();
            Excel::import(new SoalImport($kategori), $file);

            return redirect(session('soal'))->with('success', 'Berhasil Import');

                //return redirect(session('desa'))\->with('success', 'Berhasil Import');
            // } catch (Exception $e) {
            //     return redirect(session('desa'))->with('error', $e->getMessage());
            // }
        }catch(Exception $e){
            Log::info('Error ' . $e->getMessage());
        }
    }
}
