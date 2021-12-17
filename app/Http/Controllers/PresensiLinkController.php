<?php

namespace App\Http\Controllers;

use App\Agenda;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PresensiLinkController extends Controller
{
    //
    public function index($id, $ids)
    {
        $user_id = Crypt::decrypt($ids);
        $id = Crypt::decrypt($id);
        //dd($user_id, $id);

        $cek = DB::table('agenda')
            ->join('agenda_user', 'agenda_user.agenda_id', '=', 'agenda.id')
            ->join('users', 'agenda.pic', '=', 'users.id')
            ->join('ruangan', 'agenda.ruangan_id', '=', 'ruangan.id')
            ->select(
                'agenda.*',
                'users.name as pic_name',
                'ruangan.nama as nama_ruangan',
                'agenda_user.user_id as id_presensi',
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
        //dd($cek);
        if ((!empty($cek)) and ($today == $cek->tanggal)) {
            if ($cek->presensi == "belum") {
                Agenda::find($id)->user()->updateExistingPivot($user_id, array('presensi' => 'sudah', 'presensi_at' => $now), false);

                Session::flash('sukses', 'Terima kasih telah melakukan Presensi di PATRIK');
            } else if ($cek->presensi == "sudah") {
                Session::flash('error', 'Anda telah melakukan Presensi pada Rapat ini');
            }
        } else {
            // notifikasi dengan session
            Session::flash('error', 'Anda tidak diundang atau rapat telah berlalu');
        }

        $cek = DB::table('agenda')
            ->join('agenda_user', 'agenda_user.agenda_id', '=', 'agenda.id')
            ->join('users', 'agenda.pic', '=', 'users.id')
            ->join('ruangan', 'agenda.ruangan_id', '=', 'ruangan.id')
            ->select(
                'agenda.*',
                'users.name as pic_name',
                'ruangan.nama as nama_ruangan',
                'agenda_user.user_id as id_presensi',
                'agenda_user.presensi as presensi',
                'agenda_user.presensi_at as waktu_presensi'
            )
            ->where('agenda_user.user_id', '=', $user_id)
            ->where('agenda_user.agenda_id', '=', $id)
            ->first();
        //$id = Crypt::encrypt($id);
        return view("presensi/info_presensi", compact('cek'));
    }
}
