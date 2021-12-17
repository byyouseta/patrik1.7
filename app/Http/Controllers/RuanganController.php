<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ruangan;
use Crypt;
use Illuminate\Support\Facades\Session;

class RuanganController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth', 'cekstatus']);
    }

    public function index()
    {
        session()->put('halaman', 'master');

        $ruangan = Ruangan::all();
        return view('ruangan.ruangan', ['ruangan' => $ruangan]);
    }

    public function tambah()
    {

        return view('ruangan.tambahruangan');
    }

    public function tambahruangan(Request $request)
    {

        $this->validate($request, [
            'nama' => 'required',
            'lokasi' => 'required'
        ]);

        $ruangan = new Ruangan;
        $ruangan->nama = $request->nama;
        $ruangan->lokasi = $request->lokasi;
        $ruangan->keterangan = $request->keterangan;
        $ruangan->save();

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        return redirect('/ruangan');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $ruangan = Ruangan::find($id);
        return view('ruangan.ruangan_edit', ['ruangan' => $ruangan]);
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'nama' => 'required',
            'lokasi' => 'required'
        ]);

        $ruangan = Ruangan::find($id);
        $ruangan->nama = $request->nama;
        $ruangan->lokasi = $request->lokasi;
        $ruangan->keterangan = $request->keterangan;
        $ruangan->save();

        Session::flash('sukses', 'Data Berhasil diperbaharui!');

        return redirect('/ruangan');
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $ruangan = Ruangan::find($id);
        $ruangan->delete();

        Session::flash('sukses', 'Data Berhasil dihapus!');

        return redirect('/ruangan');
    }
}
