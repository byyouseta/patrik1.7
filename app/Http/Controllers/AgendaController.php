<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use DB;
use DateTime;
use App\Agenda;
use App\Gambar;
use App\User;
use App\Ruangan;
use App\Pegawai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use PDF;


class AgendaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session()->put('halaman', 'agenda');

        $tgl1 = Carbon::now()->startOfMonth();
        $tgl2 = Carbon::now()->endOfMonth();

        // dd($tgl1, $tgl2);
        // mengambil semua data pengguna
        if (Auth::user()->level == "admin") {
            $query = DB::table('agenda')
                ->join('users', 'agenda.pic', '=', 'users.id')
                ->join('ruangan', 'agenda.ruangan_id', '=', 'ruangan.id')
                ->select('agenda.*', 'ruangan.nama as nama_ruangan', 'users.name as pic_name')
                //->where('agenda.pic', '=', Auth::user()->id)
                //->select('agenda.*', 'ruangan.nama as nama_ruangan', 'agenda_user.user_id')
                //->groupBy( 'agenda_user.user_id','agenda.id', 'agenda.nama_agenda', 'agenda.tanggal', 'agenda.waktu_mulai',
                //   'agenda.waktu_selesai', 'agenda.ruangan_id', 'agenda.status', 'agenda.keterangan',
                //    'agenda.pic', 'agenda.notulen', 'agenda.updated_at', 'agenda.created_at', 'ruangan.nama')
                ->whereBetween('agenda.tanggal', [$tgl1, $tgl2])
                ->orderBy('agenda.status', 'asc')
                ->orderBy('tanggal', 'asc')
                ->get();
        } else {
            $query = DB::table('agenda')
                ->join('users', 'agenda.pic', '=', 'users.id')
                ->join('ruangan', 'agenda.ruangan_id', '=', 'ruangan.id')
                ->select('agenda.*', 'ruangan.nama as nama_ruangan', 'users.name as pic_name')
                ->where('agenda.pic', '=', Auth::user()->id)
                ->whereBetween('agenda.tanggal', [$tgl1, $tgl2])
                ->orderBy('agenda.status', 'asc')
                ->orderBy('tanggal', 'asc')
                ->get();
        }

        // return data ke view
        return view('agenda.agenda', ['agenda' => $query]);
    }

    public function cari()
    {
        session()->put('halaman', 'agenda');
        $cari = Input::get('cari');

        $string = explode('-', $cari);

        $date1 = explode('/', $string[0]);
        $date2 = explode('/', $string[1]);

        $finalDate1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $finalDate2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
        // dd($string[0], $string[1], $finalDate1, $finalDate2);

        // mengambil semua data pengguna
        if (!empty($cari)) {
            // $query2 = DB::table('agenda')
            //     ->join('users', 'agenda.pic', '=', 'users.id')
            //     ->join('ruangan', 'agenda.ruangan_id', '=', 'ruangan.id')
            //     ->select('agenda.*', 'ruangan.nama as nama_ruangan', 'users.name as pic_name')
            //     ->where('agenda.nama_agenda', 'like', '%' . $cari . '%')
            //     ->orWhere('agenda.tanggal', 'like', '%' . $cari . '%')
            //     ->orWhere('ruangan.nama', 'like', '%' . $cari . '%')
            //     ->orWhere('agenda.status', 'like', '%' . $cari . '%')
            //     ->orWhere('users.name', 'like', '%' . $cari . '%')
            //     ->orderBy('tanggal', 'asc')
            //     ->paginate(10);
            // $query2->appends(['cari' => $cari]);

            $query2 = DB::table('agenda')
                ->join('users', 'agenda.pic', '=', 'users.id')
                ->join('ruangan', 'agenda.ruangan_id', '=', 'ruangan.id')
                ->select('agenda.*', 'ruangan.nama as nama_ruangan', 'users.name as pic_name')
                ->orWhereBetween('agenda.tanggal', [$finalDate1, $finalDate2])
                ->orderBy('tanggal', 'asc')
                ->get();

            // return data ke view
            return view('agenda.agenda', ['agenda' => $query2]);
        } else {
            return redirect('/agenda');
        }
    }

    public function tambah()
    {
        # code...
        $ruangan = Ruangan::all();
        $pegawai = Auth::user();
        $pengundang = User::all();
        return view('agenda.tambahagenda', [
            'ruangan' => $ruangan,
            'pic' => $pegawai,
            'pengundang' => $pengundang
        ]);
    }

    public function tambahagenda(Request $request)
    {

        $this->validate($request, [
            'nama_agenda' => 'required|min:6',
            'ruangan' => 'required',
            'tanggal' => 'required|min:10',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'keterangan' => 'required',
            'pengundang' => 'required',
        ]);

        //Konversi waktu mulai
        $waktu_mulai = $request->get('waktu_mulai');
        $waktu_mulai = DateTime::createFromFormat('H:i A', $waktu_mulai);
        $waktu_mulai = $waktu_mulai->format('H:i:s');
        //Konversi waktu selesai
        $waktu_selesai = $request->get('waktu_selesai');
        $waktu_selesai = DateTime::createFromFormat('H:i A', $waktu_selesai);
        $waktu_selesai = $waktu_selesai->format('H:i:s');

        $pengundang = User::find($request->pengundang);
        $nama_pengudang = $pengundang->name;
        $nip_pengudang = $pengundang->username;
        $jab_pengundang = $pengundang->pegawai->jabatan;

        $pic = Auth::user()->id;

        $agenda = new Agenda;
        $agenda->nama_agenda = $request->nama_agenda;
        $agenda->ruangan_id = $request->ruangan;
        $agenda->tanggal = $request->tanggal;
        $agenda->waktu_mulai = $waktu_mulai;
        $agenda->waktu_selesai = $waktu_selesai;
        $agenda->keterangan = $request->keterangan;
        $agenda->status = 'Pengajuan';
        $agenda->pic = $pic;
        $agenda->pengundang = $nama_pengudang;
        $agenda->nip_pengundang = $nip_pengudang;
        $agenda->jab_pengundang = $jab_pengundang;
        $agenda->save();

        Session::flash('sukses', 'Data Agenda berhasil disimpan');

        return redirect('/agenda');
    }

    public function edit($id)
    {

        $id = Crypt::decrypt($id);
        $agenda = Agenda::find($id);
        $ruangan = Ruangan::all();
        $pengundang = User::all();
        return view('agenda.agenda_edit', [
            'ruangan' => $ruangan,
            'pengundang' => $pengundang,
            'agenda' => $agenda
        ]);
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'nama_agenda' => 'required|min:6',
            'ruangan' => 'required',
            'tanggal' => 'required|min:10',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'keterangan' => 'required',
            'pengundang' => 'required',
        ]);

        //Konversi waktu mulai
        $waktu_mulai = $request->get('waktu_mulai');
        $waktu_mulai = DateTime::createFromFormat('H:i A', $waktu_mulai);
        $waktu_mulai = $waktu_mulai->format('H:i:s');
        //Konversi waktu selesai
        $waktu_selesai = $request->get('waktu_selesai');
        $waktu_selesai = DateTime::createFromFormat('H:i A', $waktu_selesai);
        $waktu_selesai = $waktu_selesai->format('H:i:s');
        //pengundang
        $pengundang = User::find($request->pengundang);
        $nama_pengudang = $pengundang->name;
        $nip_pengudang = $pengundang->username;
        $jab_pengundang = $pengundang->pegawai->jabatan;
        //dd($jab_pengundang);
        $agenda = Agenda::find($id);
        $agenda->nama_agenda = $request->nama_agenda;
        $agenda->ruangan_id = $request->ruangan;
        $agenda->tanggal = $request->tanggal;
        $agenda->waktu_mulai = $waktu_mulai;
        $agenda->waktu_selesai = $waktu_selesai;
        $agenda->keterangan = $request->keterangan;
        $agenda->pengundang = $nama_pengudang;
        $agenda->nip_pengundang = $nip_pengudang;
        $agenda->jab_pengundang = $jab_pengundang;
        //$agenda->keterangan = $request->pengundang;
        if ($request->status != "") {
            $agenda->status = $request->status;
        }

        $agenda->save();

        Session::flash('sukses', 'Data Agenda berhasil diperbaharui');

        return redirect('/agenda');
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);
        $agenda = Agenda::find($id);

        $agenda->user()->detach();
        $agenda->tamu()->delete();
        $agenda->gambar()->delete();
        $agenda->delete();

        Session::flash('sukses', 'Data Agenda berhasil dihapus');

        return redirect('/agenda');
    }

    public function undangan($id)
    {
        $id = Crypt::decrypt($id);
        // mengambil semua data pengguna
        $agenda = Agenda::find($id);
        $eselon = User::where('username', '=', $agenda->nip_pengundang)->first();
        //dd($eselon);
        // lempar juga data pegawai
        $pegawai = User::all();
        $peserta = DB::table('agenda_user')
            ->where('presensi', 'sudah')
            ->where('agenda_id', $id)
            ->count();
        $gambar = Gambar::where('agenda_id', '=', $id)->get();
        // return data ke view
        return view('agenda.undangan', [
            'id' => $id,
            'agenda' => $agenda,
            'pegawai' => $pegawai,
            'presensi' => $peserta,
            'gambar' => $gambar,
            'eselon' => $eselon
        ]);
    }

    public function tambahpeserta($id, Request $request)
    {
        $this->validate($request, [
            'peserta' => 'required',
        ]);
        //UNTUK CEK SUDAH ADA BELUM SI PESERTA DALAM LIST PESERTA
        $cari = Agenda::whereHas('user', function ($query) use ($request) {
            $query->where('user_id', '=', $request->peserta)
                ->where('agenda_id', '=', $request->id);
        })->count();

        if (empty($cari)) {

            $user = $request->peserta;
            $user = User::find($user);
            $agenda = Agenda::find($id);
            $user->agenda()->attach($agenda, ['presensi' => 'belum']);

            $id = Crypt::encrypt($id);

            Session::flash('sukses2', 'Peserta Undangan berhasil ditambah');
            return redirect("/agenda/undangan/$id");
        } else {
            $id = Crypt::encrypt($id);
            return redirect("/agenda/undangan/$id")->withErrors(['Peserta sudah pernah ditambahkan', 'The Message']);
        }
    }

    public function deleteundangan($id, $ids)
    {
        $ids = Crypt::decrypt($ids);
        $agenda = Agenda::find($id)->user()->detach($ids);

        Session::flash('sukses', 'Peserta Undangan berhasil dihapus');

        $id = Crypt::encrypt($id);
        return redirect("/agenda/undangan/$id");
    }

    public function cariundangan($id)
    {
        $cari = Input::get('cari');
        $id = Crypt::decrypt($id);
        // mengambil semua data pengguna
        if (!empty($cari)) {
            $query2 = DB::table('users')
                ->join('unit', 'unit.id', '=', 'users.unit_id')
                ->join('agenda_user', 'agenda_user.user_id', '=', 'users.id')
                ->select('users.*', 'unit.nama_unit', 'agenda_user.presensi', 'agenda_user.presensi_at')
                ->Where('agenda_user.agenda_id', '=', $id)
                ->Where(function ($query) use ($cari) {
                    $query->Where('agenda_user.presensi', 'like', '%' . $cari . '%')
                        ->orWhere('users.name', 'like', '%' . $cari . '%');
                })
                //->Where()
                //->orWhere()
                ->orderBy('agenda_user.presensi_at', 'asc')
                ->get();

            /*$query2 = Agenda::whereHas('user', function ($q) use ($id, $cari) {
                $q->where('agenda_id', $id)
                    ->orWhere('users.name', 'like', '%'.$cari.'%')
                    ->orWhere('agenda_user.presensi', 'like', '%'.$cari.'%');
            })->get();*/

            $agenda = Agenda::find($id);
            // lempar juga data pegawai
            $pegawai = User::all();
            $peserta = DB::table('agenda_user')
                ->where('presensi', 'sudah')
                ->where('agenda_id', $id)
                ->count();
            //$query2->appends(['cari' => $cari]);
            //return view('undangan', ['agenda' => $query2]);
            $id = Crypt::encrypt($id);
            return view('undangan', [
                'id' => $id, 'agenda' => $agenda, 'pegawai' => $pegawai, 'presensi' => $peserta,
                'cari' => $query2
            ]);
        } else {
            // return data ke view
            $id = Crypt::encrypt($id);
            return redirect("/agenda/undangan/$id");
        }
    }

    public function upload($id, Request $request)
    {
        $this->validate($request, [
            'filepdf' => 'required|mimes:pdf|max:2048',

        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('filepdf');
        $random = Str::random(12);
        $nama_file = time() . "_" . $random . '.pdf';

        //$nama_file = time()."_".$file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'notulen_rapat';
        $file->move($tujuan_upload, $nama_file);

        $agenda = Agenda::find($id);
        $agenda->notulen = $nama_file;
        $agenda->status = 'Selesai';
        $agenda->save();

        Session::flash('sukses', 'Data berhasil diunggah');

        $id = Crypt::encrypt($id);
        return redirect("/agenda/undangan/$id");
    }

    public function daftarhadir($id, Request $request)
    {
        $this->validate($request, [
            'filedaftar' => 'required|mimes:pdf,jpeg,jpg|max:2048',

        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('filedaftar');
        $random = Str::random(12);
        $extension = $file->getClientOriginalExtension();
        $nama_file = time() . "_" . $random . '.' . $extension;

        //$nama_file = time()."_".$file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'daftar_hadir';
        $file->move($tujuan_upload, $nama_file);

        $agenda = Agenda::find($id);
        $agenda->daftar = $nama_file;
        $agenda->save();

        Session::flash('sukses', 'Data berhasil diunggah');

        $id = Crypt::encrypt($id);
        return redirect("/agenda/undangan/$id");
    }

    public function materi($id, Request $request)
    {
        $this->validate($request, [
            'filemateri' => 'required|mimes:pdf,ppt,pptx|max:2048',

        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('filemateri');
        $random = Str::random(12);
        $extension = $file->getClientOriginalExtension();
        $nama_file = time() . "_" . $random . '.' . $extension;

        //$nama_file = time()."_".$file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'materi';
        $file->move($tujuan_upload, $nama_file);

        $agenda = Agenda::find($id);
        $agenda->materi = $nama_file;
        $agenda->save();

        Session::flash('sukses', 'Data berhasil diunggah');

        $id = Crypt::encrypt($id);
        return redirect("/agenda/undangan/$id");
    }

    public function dokumentasi($id, Request $request)
    {
        $this->validate($request, [
            'filedokumentasi' => 'required|mimes:jpeg,jpg|max:1024',

        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('filedokumentasi');
        $random = Str::random(12);
        $extension = $file->getClientOriginalExtension();
        $nama_file = time() . "_" . $random . '.' . $extension;

        //$nama_file = time()."_".$file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'dokumentasi';
        $file->move($tujuan_upload, $nama_file);

        // $gambars = Gambar::find($id);
        // $agenda->materi = $nama_file;
        // $agenda->save();

        $gambars = new Gambar;
        $gambars->gambar = $nama_file;
        $gambars->agenda_id = $id;
        $gambars->save();

        Session::flash('sukses', 'Data berhasil diunggah');

        $id = Crypt::encrypt($id);
        return redirect("/agenda/undangan/$id");
    }

    public function view($file)
    {
        // Force download of the file
        $this->file_to_download   = 'notulen_rapat/' . $file;
        //return response()->streamDownload(function () {
        //    echo file_get_contents($this->file_to_download);
        //}, $file.'.pdf');
        return response()->file($this->file_to_download);
    }

    public function viewdaftar($file)
    {
        // Force download of the file
        $this->file_to_download   = 'daftar_hadir/' . $file;
        //return response()->streamDownload(function () {
        //    echo file_get_contents($this->file_to_download);
        //}, $file.'.pdf');
        return response()->file($this->file_to_download);
    }

    public function viewmateri($file)
    {
        // Force download of the file
        $this->file_to_download   = 'materi/' . $file;
        //return response()->streamDownload(function () {
        //    echo file_get_contents($this->file_to_download);
        //}, $file.'.pdf');
        return response()->file($this->file_to_download);
    }

    public function viewdokumentasi($file)
    {
        // Force download of the file
        $this->file_to_download   = 'dokumentasi/' . $file;
        //return response()->streamDownload(function () {
        //    echo file_get_contents($this->file_to_download);
        //}, $file.'.pdf');
        return response()->file($this->file_to_download);
    }

    public function verifikasi(Request $request)
    {

        $this->validate($request, [
            'status' => 'required',
            'catatan' => 'required',
        ]);

        $id = $request->get('id');
        $agenda = Agenda::find($id);
        $verifikator = Auth::user()->name;
        $agenda->verifikator = $verifikator;
        $agenda->catatan = $request->get('catatan');
        $agenda->status = $request->get('status');

        if (!empty($request->no_undangan)) {
            $eselon = User::where('username', '=', $agenda->nip_pengundang)->first();
            $tahun = new DateTime();
            $tahun = $tahun->format('Y');
            $undangan = "UM.02.08/XLVIII." . $eselon->pegawai->eselon . "/" . $request->no_undangan . "/" . $tahun;

            //dd($undangan);
            $agenda->no_undangan = $undangan;
        }

        $agenda->save();

        Session::flash('sukses', 'Data berhasil disimpan!');

        $id = Crypt::encrypt($id);
        return redirect("/agenda/undangan/$id");
    }

    public function notulen($id, Request $request)
    {
        // $this->validate($request, [
        // 	'notulen_ol' => 'required',

        // ]);

        $agenda = Agenda::find($id);
        $agenda->notulen_ol = $request->get('notulen_ol');
        $agenda->save();

        Session::flash('sukses', 'Data berhasil disimpan');

        $id = Crypt::encrypt($id);
        return redirect("/agenda/undangan/$id");
    }

    public function cetakundangan($id)
    {
        $id = Crypt::decrypt($id);
        // mengambil data id rapat
        $agenda = Agenda::findOrFail($id);
        $hadir = $agenda->user()
            ->orderBy('agenda_user.id', 'asc')
            ->get();


        $pdf = PDF::loadview('agenda.undangan_pdf', ['agenda' => $agenda, 'peserta' => $hadir]);

        // (Optional) Setup the paper size and orientation
        $pdf->setPaper('A4', 'potraid');

        return $pdf->stream();
    }

    public function selesai($id)
    {
        $id = Crypt::decrypt($id);

        $selesai = Agenda::find($id);
        $selesai->status = "Selesai";
        $selesai->save();

        Session::flash('sukses', 'Data berhasil diperbaharui');

        $id = Crypt::encrypt($id);
        return redirect("/agenda/undangan/$id");
    }
}
