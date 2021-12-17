<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Crypt;
use Illuminate\Support\Facades\Input;
use DB;
use App\User;
use App\Pegawai;
use App\Unit;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use Illuminate\Support\Facades\Session;

class PegawaiController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth', 'cekstatus']);
        set_time_limit(500000);
    }

    public function index()
    {
        session()->put('halaman', 'master');
        // mengambil semua data pengguna
        $pegawai = User::paginate(10);
        // return data ke view
        return view('pegawai.pegawai', ['pegawai' => $pegawai]);
    }

    public function cari()
    {
        $cari = Input::get('cari');
        // mengambil semua data pengguna
        if (!empty($cari)) {
            $pegawai = DB::table('users')
                ->join('unit', 'unit.id', '=', 'users.unit_id')
                ->join('pegawai', 'pegawai.user_id', '=', 'users.id')
                ->select(
                    'users.*',
                    'unit.nama_unit as nama_unit',
                    'pegawai.alamat as alamat',
                    'pegawai.no_hp as no_hp'
                )
                ->where('users.name', 'like', '%' . $cari . '%')
                ->orWhere('pegawai.alamat', 'like', '%' . $cari . '%')
                ->orWhere('unit.nama_unit', 'like', '%' . $cari . '%')
                ->orderBy('users.name', 'asc')
                ->paginate(10);
            $pegawai->appends(['cari' => $cari]);

            // return data ke view
            return view('pegawai.pegawai', ['cari' => $pegawai]);
        } else {
            return redirect('/pegawai');
        }
    }

    public function tambah()
    {
        # code...
        $unit = Unit::all();
        return view('pegawai.tambahpegawai', ['unit' => $unit]);
    }

    public function tambahpegawai(Request $request)
    {

        $this->validate($request, [
            'username' => 'required|min:5|unique:users',
            'name' => 'required',
            'no_hp' => 'required|min:10|max:15|unique:pegawai',
            'email' => 'required|email|unique:users',
            'level' => 'required',
            'alamat' => 'required',
            'jabatan' => 'required',
            'unit' => 'required',
            //'eselon' => 'required',
        ]);

        $user = new User;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = $request->level;
        $user->unit_id = $request->unit;
        $user->password = Hash::make($request->username);
        $user->save();

        $pegawai = new Pegawai;
        $pegawai->jabatan = $request->jabatan;
        $pegawai->eselon = $request->eselon;
        $pegawai->alamat = $request->alamat;
        $pegawai->no_hp = $request->no_hp;
        $user->pegawai()->save($pegawai);

        Session::flash('sukses', 'Data Berhasil disimpan!');

        return redirect('/pegawai');
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $pegawai = User::find($id);
        $pegawai->delete();

        Session::flash('sukses', 'Data Berhasil dihapus!');

        return redirect('/pegawai');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $pegawai = User::find($id);
        $unit = Unit::all();
        return view('pegawai.pegawai_edit', ['pegawai' => $pegawai, 'unit' => $unit]);
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            //'username' => 'required|min:6',
            'name' => 'required',
            'no_hp' => 'required|min:10',
            'email' => 'required|email',
            'level' => 'required',
            'jabatan' => 'required',
        ]);

        $user = User::find($id);
        //$user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = $request->level;
        $user->unit_id = $request->unit;


        //$user = User::find($id); 
        $user->pegawai->alamat = $request->alamat;
        $user->pegawai->jabatan = $request->jabatan;
        $user->pegawai->eselon = $request->eselon;
        $user->pegawai->no_hp = $request->no_hp;
        //$user->pegawai()->save($pegawai);
        $user->push();

        Session::flash('sukses', 'Data Berhasil Diperbaharui!');

        return redirect('/pegawai');
    }

    public function import_excel(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_pegawai', $nama_file);
        //$file->storeAs('file_pegawai', $nama_file);

        // import data
        Excel::import(new UserImport, public_path('/file_pegawai/' . $nama_file));

        // notifikasi dengan session
        Session::flash('sukses', 'Data Pegawai Berhasil Diimport!');

        // alihkan halaman kembali
        return redirect('/pegawai');
    }
}
