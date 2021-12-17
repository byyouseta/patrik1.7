<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfilController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session()->put('halaman', 'profil');
        // mengambil semua data pengguna
        $pegawai = User::find(Auth::user()->id);
        $unit = Unit::all();
        //dd($pegawai);
        // return data ke view
        return view('auth.profile', [
            'user' => $pegawai,
            'unit' => $unit
        ]);
    }

    public function update($id, Request $request)
    {
        //dd($request->email);
        $this->validate($request, [
            'username' => 'required|min:5|unique:users,username,' . $id,
            'name' => 'required',
            'nohp' => 'required|min:10|unique:pegawai,no_hp,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'unit' => 'required',
            'alamat' => 'required',
            'jabatan' => 'required',
            'foto' => 'mimes:jpg,jpeg,png|max:200',
        ]);

        $user = User::find($id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        //$user->level = $request->level;
        $user->unit_id = $request->unit;


        //$user = User::find($id); 
        $user->pegawai->alamat = $request->alamat;
        $user->pegawai->jabatan = $request->jabatan;
        $user->pegawai->no_hp = $request->nohp;
        if (isset($request->foto)) {
            $file = $request->file('foto');
            $random = Str::random(12);
            $extension = $file->getClientOriginalExtension();
            $nama_file = time() . "_" . $random . '.' . $extension;

            $tujuan_upload = 'foto_profil';
            $file->move($tujuan_upload, $nama_file);

            $user->foto = $nama_file;
        }

        $user->push();

        $request->session()->flash('sukses', 'Data berhasil diupdate');

        return redirect('/profil');
    }
}
