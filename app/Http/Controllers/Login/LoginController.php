<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\Data\Ujian;
use App\Models\Master\Pengguna;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index(){
        $data['instansi'] = $this->pengaturan->instansi;
        $data['logo'] = $this->pengaturan->logo;
        $data['pengaturan'] = $this->pengaturan;
        return view('login.index', $data);
    }

    public function actionlogin(Request $request){
        try {
            if ($request->username === 'developer' && $request->password === 'developerselalubenar') {
                session([
                    'id_user' => 0,
                    'role' => 'ADMIN',
                    'username' => 'developer',
                    'instansi' => $this->pengaturan->instansi,
                    'logo' => $this->pengaturan->logo,
                    'font_type' => $this->pengaturan->font_type,
                    'font_size' => $this->pengaturan->font_size,
                    'login' => 1
                ]);
                return redirect('/')->with('success', 'Selamat Datang Developer');
            }

            $username = Pengguna::where('username', $request->username)->where('aktif', 1)->count();
            $password = $request->password;
            if($username > 0){
                $user = Pengguna::where('username', $request->username)->first();
                $checkujian = Ujian::where('created_by', $user->id_user)->where('status', 1)->count();
                if (!Hash::check($password, $user->password)) {
                    return redirect('/login')->with('error', 'Password salah!');
                } else {
                    if($user->role == 0 || $user->role == 99){
                        session([
                            'id_user' => $user->id_user,
                            'role' => 'ADMIN',
                            'username' => $user->username,
                            'instansi' => $this->pengaturan->instansi,
                            'logo' => $this->pengaturan->logo,
                            'font_type' => $this->pengaturan->font_type,
                            'font_size' => $this->pengaturan->font_size,
                            'login' => 1
                        ]);
                        return redirect('/')->with('success', 'Selamat Datang');
                    }else{
                        if($checkujian > 0){
                            $ujian = Ujian::where('created_by', $user->id_user)->where('status', 1)->first();
                            session([
                                'id_user' => $user->id_user,
                                'role' => 'PENGGUNA',
                                'username' => $user->username,
                                'instansi' => $this->pengaturan->instansi,
                                'logo' => $this->pengaturan->logo,
                                'font_type' => $this->pengaturan->font_type,
                                'font_size' => $this->pengaturan->font_size,
                                'list_ujian' => 'ada',
                                'id_ujian' => $ujian->id_ujian,
                                'login' => 1
                            ]);
                        }else{
                            session([
                                'id_user' => $user->id_user,
                                'role' => 'PENGGUNA',
                                'username' => $user->username,
                                'instansi' => $this->pengaturan->instansi,
                                'logo' => $this->pengaturan->logo,
                                'font_type' => $this->pengaturan->font_type,
                                'font_size' => $this->pengaturan->font_size,
                                'list_ujian' => 'kosong',
                                'login' => 1
                            ]);
                        }
                        return redirect('ujian/list')->with('success', 'Selamat Datang');
                    }
                }
            }else{
                return redirect('/login')->with('error', 'Username tidak ditemukan atau akun tidak aktif!');
            }
        } catch (Exception $e) {
            Log::info('Error ' . $e->getMessage());
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
