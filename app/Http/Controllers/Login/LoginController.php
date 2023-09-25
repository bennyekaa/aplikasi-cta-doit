<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
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
                if (!Hash::check($password, $user->password)) {
                    return redirect('/login')->with('error', 'Password salah!');
                } else {
                    if($user->username == 'admin'){
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
                            session([
                                'id_user' => $user->id_user,
                                'role' => 'PENGGUNA',
                                'username' => $user->username,
                                'email' => $user->email,
                                'login' => 1
                            ]);
                            return redirect('/')->with('success', 'Selamat Datang');
                        }else{
                            return redirect('/login')->with('error', 'Anda Tidak Memiliki Langganan, Silahkan Hubungi WA 08563498050 untuk berlangganan!');
                        }
                    }
                }
            }elseif($email > 0){
                $user = Pengguna::where('email', $request->email)->first();
                if (!Hash::check($password, $user->password)) {
                    return redirect('/login')->with('error', 'Password salah!');
                } else {
                    if($user->email == 'admin'){
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
                            session([
                                'id_user' => $user->id_user,
                                'role' => 'PENGGUNA',
                                'username' => $user->username,
                                'email' => $user->email,
                                'login' => 1
                            ]);
                            return redirect('/')->with('success', 'Selamat Datang');
                        } else {
                            return redirect('/login')->with('error', 'Anda Tidak Memiliki Langganan, Silahkan Hubungi WA 08563498050 untuk berlangganan!');
                        }
                    }
                }
            }else{
                return redirect('/login')->with('error', 'Anda Tidak Memiliki Langganan, Silahkan Hubungi WA 08563498050 untuk berlangganan!');
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
