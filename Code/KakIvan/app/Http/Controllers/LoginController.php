<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sopir;
use App\Jasa;
use App\Order;
use App\Pelanggan;
use App\Manager;

class LoginController extends Controller
{
    public function show() {
        return view('login.login');
    }

    public function createUser() {
        $nama = 'Kak Ivan';
        $username = 'kakivan';
        $password = 'kakivan2000';

        $hash = password_hash($password,PASSWORD_DEFAULT);
        Manager::updateOrCreate([
            'nama_manager' => $nama,
            'username' => $username ,
            'password' => $hash
        ]);
        return ('berhasil');
    }

    public function login(Request $request) {
        $data = Manager::all();
        foreach($data as $d) {
            if ( password_verify($request->password, $d->password ) && $request->user == $d->username ) {
                $_SESSION['user'] = $d->nama_manager;
                session(['user' => $d->nama_manager]);
                return redirect('/')->with([
                    'message' => 'Selamat Datang ' . $d->nama_manager,
                    'status' => 1,
                ]);
            }
        }
        session()->flash('message' , 'Gagal Login, Password atau Username Salah!!!');
        session()->flash('status' , -1);
        return redirect('/login')->with([
            'message' => 'Gagal Login, Password atau Username Salah!!!'
        ]);
    }

    public function logout() {
        session()->pull('user');
        return redirect('/login')->with([
            'message' => 'Anda telah Logout ',
            'status' => 1,
        ]);
    }
}