<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use \Crypt;
use DateTime;
use App\Agenda;
use App\Pegawai;
use App\User;
use App\Tamu;
use PDF;
use App\Mail\PresensiEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Jobs\SendEmailJob;

class PresensiController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index($id)
    // {
    //     $id = Crypt::decrypt($id);
    //     // mengambil semua data pengguna
    //     $agenda = Agenda::find($id);
    //     $pegawai = Auth::user();
    //     // return data ke view
    //     return view('presensi', ['agenda' => $agenda, 'pegawai' => $pegawai]);
    // }
    public function index()
    {
        session()->put('halaman', 'presensi');

        $query = DB::table('agenda')
            ->join('agenda_user', 'agenda_user.agenda_id', '=', 'agenda.id')
            ->join('users', 'agenda.pic', '=', 'users.id')
            ->join('ruangan', 'agenda.ruangan_id', '=', 'ruangan.id')
            ->select(
                'agenda.*',
                'ruangan.nama as nama_ruangan',
                'users.name as pic_name',
                'agenda_user.presensi as presensi',
                'agenda_user.presensi_at as waktu_presensi'
            )
            ->where('agenda_user.user_id', '=', Auth::user()->id)
            ->orderBy('agenda.status', 'asc')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('presensi.presensi_new', ['agenda' => $query]);
    }

    public function presensi($id, $ids)
    {
        $user_id = Crypt::decrypt($ids);
        $id = Crypt::decrypt($id);

        $cek = DB::table('agenda')
            ->join('agenda_user', 'agenda_user.agenda_id', '=', 'agenda.id')
            ->join('users', 'agenda.pic', '=', 'users.id')
            ->select(
                'agenda.*',
                'users.name as pic_name',
                'agenda_user.presensi as presensi',
                'agenda_user.presensi_at as waktu_presensi'
            )
            ->where('agenda_user.user_id', '=', $user_id)
            ->where('agenda_user.agenda_id', '=', $id)
            ->first();

        $now = new DateTime();
        $now = $now->format('Y-m-d H:i:s');
        $today = new DateTime();
        $today = $today->format('Y-m-d');
        //dd($user_id, $id);
        if ((!empty($cek)) and ($today == $cek->tanggal)) {

            Agenda::find($id)->user()->updateExistingPivot($user_id, array('presensi' => 'sudah', 'presensi_at' => $now), false);

            Session::flash('sukses', 'Terima kasih telah presensi di PATRIK');
        } else {
            // notifikasi dengan session
            Session::flash('error', 'Anda tidak diundang atau rapat telah berlalu');
        }

        $id = Crypt::encrypt($id);
        return redirect("presensi");
    }

    public function hadir($id)
    {
        $id = Crypt::decrypt($id);
        // mengambil data id rapat
        //dd($id);
        $agenda = Agenda::findOrFail($id);
        $hadir = $agenda->user()
            ->wherePivot('presensi_at', '!=', '')
            ->get();

        $tamu = Tamu::where('agenda_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();
        // return data ke view
        return view('agenda.daftarhadir', ['agenda' => $agenda, 'peserta' => $hadir, 'tamu' => $tamu]);
    }

    public function cetakhadir($id)
    {
        $id = Crypt::decrypt($id);
        // mengambil data id rapat
        $agenda = Agenda::findOrFail($id);
        $hadir = $agenda->user()
            ->wherePivot('presensi_at', '!=', '')
            ->get();

        $tamu = Tamu::where('agenda_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();
        // return data ke view
        $pdf = PDF::loadview('agenda.daftarhadir_pdf', ['agenda' => $agenda, 'peserta' => $hadir, 'tamu' => $tamu]);

        return $pdf->stream();
    }

    public function email($id, $ids)
    {
        $agenda = Agenda::find($id);
        $ids = Crypt::decrypt($ids);
        $user = User::find($ids);

        $data = [
            'nama' => $user->name,
            'nama_agenda' => $agenda->nama_agenda,
            'tanggal' => $agenda->tanggal,
            'mulai' => $agenda->waktu_mulai,
            'selesai' => $agenda->waktu_selesai,
            'nama_ruangan' => $agenda->ruangan->nama,
            'keterangan' => $agenda->keterangan,
            'pic' => $agenda->userpic->name,
            'pengundang' => $agenda->pengundang,
            'link' => 'http://e-rapat.rsupsurakarta.co.id/notifikasi/' . Crypt::encrypt($agenda->id) . '/' . Crypt::encrypt($user->id),
        ];
        //dd($data);
        //email
        Mail::to($user->email)->send(new PresensiEmail($data));

        Session::flash('sukses', 'Email berhasil dikirim!');

        $id = Crypt::encrypt($id);
        return redirect("/agenda/undangan/$id");
    }

    public function brute_email($id)
    {
        //$agenda = Agenda::find($id);
        $id = Crypt::decrypt($id);
        //$user = User::find($ids);
        $cek = DB::table('agenda')
            ->join('agenda_user', 'agenda_user.agenda_id', '=', 'agenda.id')
            ->join('users', 'agenda.pic', '=', 'users.id')
            ->join('ruangan', 'agenda.ruangan_id', '=', 'ruangan.id')
            ->select(
                'agenda.*',
                'users.name as pic_name',
                'users.email as email',
                'ruangan.nama as nama_ruangan',
                'agenda_user.id as id_presensi',
                'agenda_user.user_id',
                'agenda_user.presensi_at as waktu_presensi'
            )
            //->where('agenda_user.user_id', '=', $user_id)
            ->where('agenda_user.agenda_id', '=', $id)
            ->get();
        //dd($cek);
        if (!empty($cek)) {
            foreach ($cek as $kirim) {
                # code...

                $antri = User::find($kirim->user_id);
                //dd($antri, $kirim);
                $data = [
                    'nama' => $antri->name,
                    'email' => $antri->email,
                    'nama_agenda' => $kirim->nama_agenda,
                    'tanggal' => $kirim->tanggal,
                    'mulai' => $kirim->waktu_mulai,
                    'selesai' => $kirim->waktu_selesai,
                    'nama_ruangan' => $kirim->nama_ruangan,
                    'keterangan' => $kirim->keterangan,
                    'pic' => $kirim->pic_name,
                    'pengundang' => $kirim->pengundang,
                    'link' => 'http://e-rapat.rsupsurakarta.co.id/notifikasi/' . Crypt::encrypt($kirim->id) . '/' . Crypt::encrypt($antri->id),
                ];

                dispatch(new SendEmailJob($data));

                Session::flash('sukses', 'Email berhasil dikirim!');
            }
        }

        //email
        //Mail::to($user->email)->send(new PresensiEmail($data));

        //$details['email'] = 'your_email@gmail.com';

        $id = Crypt::encrypt($id);
        return redirect("/agenda/undangan/$id");
    }
}
