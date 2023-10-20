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
        return view('login.index');
    }

    public function actionlogin(Request $request){
        try {
            // dd($request->all());
            $username = Pengguna::where('username', $request->email)->where('aktif', 1)->count();
            $email = Pengguna::where('email', $request->email)->where('aktif', 1)->count();
            $password = $request->password;
            if($username > 0){
                $user = Pengguna::where('username', $request->email)->first();
                $checkujian = Ujian::where('created_by', $user->id_user)->where('status', 1)->count();
                if (!Hash::check($password, $user->password)) {
                    return redirect('/login')->with('error', 'Password salah!');
                } else {
                    if($user->role == 0 || $user->role == 99){
                        session([
                            'id_user' => $user->id_user,
                            'role' => 'ADMIN',
                            'username' => $user->username,
                            'email' => $user->email,
                            'login' => 1
                        ]);
                        return redirect('/')->with('success', 'Selamat Datang');
                    }else{
                        $check = Pengguna::where('username', $request->email)->whereDate('tanggal_aktif', '>=', Carbon::today())->count();
                        if($check > 0){
                            if($checkujian > 0){
                                $ujian = Ujian::where('created_by', $user->id_user)->where('status', 1)->first();
                                session([
                                    'id_user' => $user->id_user,
                                    'role' => 'PENGGUNA',
                                    'username' => $user->username,
                                    'email' => $user->email,
                                    'list_ujian' => 'ada',
                                    'id_ujian' => $ujian->id_ujian,
                                    'login' => 1
                                ]);
                            }else{
                                session([
                                    'id_user' => $user->id_user,
                                    'role' => 'PENGGUNA',
                                    'username' => $user->username,
                                    'email' => $user->email,
                                    'list_ujian' => 'kosong',
                                    'login' => 1
                                ]);
                            }
                            return redirect('ujian/list')->with('success', 'Selamat Datang');
                        }else{
                            return redirect('/login')->with('error', 'Anda Tidak Memiliki Langganan, Silahkan Hubungi WA 082137345435 untuk berlangganan!');
                        }
                    }
                }
            }elseif($email > 0){
                $user = Pengguna::where('email', $request->email)->first();
                $checkujian = Ujian::where('created_by', $user->id_user)->where('status', 1)->count();
                if (!Hash::check($password, $user->password)) {
                    return redirect('/login')->with('error', 'Password salah!');
                } else {
                    if($user->role == 0){
                        session([
                            'id_user' => $user->id_user,
                            'role' => 'ADMIN',
                            'username' => $user->username,
                            'email' => $user->email,
                            'login' => 1
                        ]);
                        return redirect('/')->with('success', 'Selamat Datang');
                    }else{
                        $check = Pengguna::where('email', $request->email)->whereDate('tanggal_aktif', '>=', Carbon::today())->count();
                        if ($check > 0) {
                            if($checkujian > 0){
                                $ujian = Ujian::where('created_by', $user->id_user)->where('status', 1)->first();
                                session([
                                    'id_user' => $user->id_user,
                                    'role' => 'PENGGUNA',
                                    'username' => $user->username,
                                    'email' => $user->email,
                                    'ujian' => 'ada',
                                    'id_ujian' => $ujian->id_ujian,
                                    'login' => 1
                                ]);
                            }else{
                                session([
                                    'id_user' => $user->id_user,
                                    'role' => 'PENGGUNA',
                                    'username' => $user->username,
                                    'email' => $user->email,
                                    'ujian' => 'kosong',
                                    'login' => 1
                                ]);
                            }
                            return redirect('ujian/list')->with('success', 'Selamat Datang');
                        } else {
                            return redirect('/login')->with('error', 'Anda Tidak Memiliki Langganan, Silahkan Hubungi WA 082137345435 untuk berlangganan!');
                        }
                    }
                }
            }else{
                return redirect('/login')->with('error', 'Anda Tidak Memiliki Langganan, Silahkan Hubungi WA 082137345435 untuk berlangganan!');
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
