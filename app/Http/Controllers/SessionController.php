<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PharIo\Manifest\Author;

class SessionController extends Controller
{
    function index()
    {
        return view("sesi/index");
    }
    function login(Request $request)
    {
        Session::flash('email', $request->email);
        $request->validate(['email' => 'required','password' => 'required'], ['email.required' => 'Email wajib diisi!','password.required' => 'Password wajib diisi!']);

        $infologin = ['email' => $request->email, 'password' => $request->password];

        if(Auth::attempt($infologin)) {
            //jika otentikasi sukses
            return redirect('mahasiswa')->with('success','Berhasil');
        } else{
            //jika otentikasi gagal
            //return 'gagal';
            return redirect('sesi')->withErrors('username dan password salah');
        }

    }

    function logout(){
        Auth::logout();
        return redirect('sesi')->with('success','berhasil logout');
    }

    function register(){
        return view('sesi/register');
    }

    function create(Request $request){
        Session::flash('name', $request->name);
        Session::flash('email', $request->email);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ], [
            'name.required' => 'Name wajib diisi',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Masukkan email yang valid',
            'email.unique' => 'Email sudah pernah digunakan',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Minumal password adalah 6 karakter']);

            $data = [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=> Hash::make($request->password)
            ];

            User::create($data);

        $infologin = ['email' => $request->email, 'password' => $request->password];

        if(Auth::attempt($infologin)) {
            //jika otentikasi sukses
            return redirect('sesi')->with('success', Auth::user()->name . 'Berhasil');
        } else{
            //jika otentikasi gagal
            //return 'gagal';
            return redirect('register')->withErrors('username dan password salah');
        }
    }
}
?>
