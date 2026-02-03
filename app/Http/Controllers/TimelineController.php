<?php

namespace App\Http\Controllers;

use App\AgendaTimeline;
use App\BuktiTimeline;
use App\CatatanSpi;
use App\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class TimelineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('dashboard');
    }

    public function dashboard()
    {
        // Query untuk menghitung jumlah tugas selesai dan belum selesai
        $data = DB::table('agenda_timelines')
            ->join('unit', 'unit.id', '=', 'agenda_timelines.unit_id')
            ->select(
                'agenda_timelines.unit_id',
                'unit.nama_unit',
                DB::raw("SUM(CASE WHEN agenda_timelines.progress = 'Belum Mulai' THEN 1 ELSE 0 END) AS belum_mulai"),
                DB::raw("SUM(CASE WHEN agenda_timelines.progress = 'Proses' THEN 1 ELSE 0 END) AS proses"),
                DB::raw("SUM(CASE WHEN agenda_timelines.progress = 'Selesai' THEN 1 ELSE 0 END) AS selesai")
            )
            ->groupBy('agenda_timelines.unit_id', 'unit.nama_unit')
            ->get();

        // dd($tasks);

        // Mengembalikan data ke view
        return view('dashboard', compact('data'));
    }

    public function index()
    {
        session()->put('halaman', 'timeline');

        $cek = AgendaTimeline::getUnitTime(Auth::user()->unit_id);

        if ($cek || Auth::user()->level == 'admin') {
            $data = AgendaTimeline::orderBy('waktu_selesai', 'ASC')
                ->get();
        } else {
            $data = AgendaTimeline::where('pic', Auth::user()->id)
                ->orderBy('waktu_selesai', 'ASC')
                ->get();
        }

        return view('agenda.timeline', compact('data'));
    }

    public function tambah()
    {
        $pegawai = User::all();
        $unit = Unit::all();

        return view('agenda.tambah_timeline', compact('pegawai', 'unit'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'nama_timeline' => 'required',
            'target' => 'required',
            'instruktor' => 'required',
            'pic' => 'required',
            'timker' => 'required',
            'mulai' => 'required|date',
            'selesai' => 'required|date'
        ]);

        $nama_instruktur = User::find($request->instruktor);
        // dd($nama_instruktur, $request);

        $simpan = new AgendaTimeline();
        $simpan->nama_timeline = $request->nama_timeline;
        $simpan->target = $request->target;
        $simpan->instruktor_id = $request->instruktor;
        $simpan->instruktor = $nama_instruktur->name;
        $simpan->unit_id = $request->timker;
        $simpan->pic = $request->pic;
        $simpan->waktu_mulai = $request->mulai;
        $simpan->waktu_selesai = $request->selesai;
        $simpan->aktual = 0;
        $simpan->progress = 'Belum Mulai';
        $simpan->save();

        Session::flash('sukses', 'Data berhasil ditambahkan');

        return redirect()->route('timeline.home');
    }

    public function delete($id)
    {
        $id = Crypt::decrypt($id);

        $delete = AgendaTimeline::find($id);

        $delete->delete();

        Session::flash('sukses', 'Data berhasil dihapus');

        return redirect()->route('timeline.home');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);

        $data = AgendaTimeline::find($id);
        $pegawai = User::all();
        $unit = Unit::all();

        return view('agenda.edit_timeline', compact('data', 'pegawai', 'unit'));
    }

    public function update(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'nama_timeline' => 'required',
            'target' => 'required',
            'pic' => 'required',
            'timker' => 'required',
            'mulai' => 'date',
            'selesai' => 'date',
            'hambatan' => 'nullable',
            'rtl' => 'required_if:hambatan,!=,null',
            'aktual' => 'required|numeric',
            'progres' => 'required'
        ]);

        $nama_instruktur = User::find($request->instruktor);
        // dd($nama_instruktur, $request);

        $simpan = AgendaTimeline::find($request->id);
        if ($request->filled('nama_timeline')) {
            $simpan->nama_timeline = $request->nama_timeline;
        }
        if ($request->filled('target')) {
            $simpan->target = $request->target;
        }
        if ($request->filled('instruktor')) {
            $simpan->instruktor_id = $request->instruktor;
        }
        if ($nama_instruktur) {
            $simpan->instruktor = $nama_instruktur->name;
        }
        if ($request->filled('timker')) {
            $simpan->unit_id = $request->timker;
        }
        if ($request->filled('pic')) {
            $simpan->pic = $request->pic;
        }
        if ($request->filled('mulai')) {
            $simpan->waktu_mulai = $request->mulai;
        }
        if ($request->filled('selesai')) {
            $simpan->waktu_selesai = $request->selesai;
        }
        if ($request->filled('hambatan')) {
            $simpan->hambatan = $request->hambatan;
        }
        if ($request->filled('rtl')) {
            $simpan->rtl = $request->rtl;
        }
        if ($request->filled('progres')) {
            $simpan->progress = $request->progres;
        }
        $simpan->save();

        Session::flash('sukses', 'Data berhasil diperbaharui');

        return redirect()->route('timeline.home');
    }

    public function detail($id)
    {
        $id = Crypt::decrypt($id);

        $data = AgendaTimeline::find($id);
        // $pegawai = User::all();
        // $unit = Unit::all();

        return view('agenda.detail_timeline', compact('data'));
    }

    public function bukti(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'timeline_id' => 'required',
            'keterangan' => 'required',
            'file' => 'required|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:2048'
        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('file');
        $tipe = $file->getClientOriginalExtension();
        $random = Str::random(5);
        $nama_file = time() . "_" . $random . '.' . $tipe;

        //$nama_file = time()."_".$file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'bukti_timeline';
        $file->move($tujuan_upload, $nama_file);

        if ($file) {
            $simpan = new BuktiTimeline();
            $simpan->agenda_timeline_id = $request->timeline_id;
            $simpan->nama_file = $nama_file;
            $simpan->keterangan = $request->keterangan;
            $simpan->save();

            Session::flash('sukses', 'File berhasil diunggah');
        }

        return redirect()->back();
    }

    public function catatan(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'timeline_id' => 'required',
            'catatan' => 'required',
            'valid' => 'required'
        ]);

        $simpan = new CatatanSpi();
        $simpan->agenda_timeline_id = $request->timeline_id;
        $simpan->valid = $request->valid;
        $simpan->catatan = $request->catatan;
        $simpan->save();

        if ($simpan) {
            Session::flash('sukses', 'Catatan berhasil ditambahkan');
        } else {
            Session::flash('sukses', 'Catatan gagal disimpan');
        }

        return redirect()->back();
    }

    public function deleteBukti($id)
    {
        $id = Crypt::decrypt($id);

        $delete = BuktiTimeline::find($id);
        // Nama file yang ingin dihapus (relatif terhadap folder public)
        $filePath = public_path("bukti_timeline/$delete->nama_file");

        // Periksa apakah file ada
        if (File::exists($filePath)) {
            // Hapus file
            File::delete($filePath);

            $delete->delete();

            Session::flash('sukses', 'Data berhasil dihapus');
        } else {
            Session::flash('error', 'File tidak ditemukan');
        }

        return redirect()->back();
    }

    public function deleteCatatan($id)
    {
        $id = Crypt::decrypt($id);

        $delete = CatatanSpi::find($id);

        if ($delete) {
            $delete->delete();
            Session::flash('sukses', 'Data berhasil dihapus');
        } else {
            Session::flash('error', 'Data tidak ditemukan');
        }

        return redirect()->back();
    }

    public function saveCatatan(Request $request)
    {
        // Validasi data
        $request->validate([
            'catatan' => 'required',
            'valid' => 'required|boolean',
        ]);

        if ($request->has('catatan_id')) {
            // Update data
            $catatan = CatatanSpi::findOrFail($request->catatan_id);
            $catatan->update([
                'catatan' => $request->catatan,
                'valid' => $request->valid,
            ]);

            return redirect()->back()->with('success', 'Catatan berhasil diupdate.');
        } else {
            // Simpan data baru
            CatatanSpi::create([
                'catatan' => $request->catatan,
                'valid' => $request->valid,
            ]);

            return redirect()->back()->with('success', 'Catatan berhasil ditambahkan.');
        }
    }

    public function viewBukti($id)
    {
        $id = Crypt::decrypt($id);

        $bukti = BuktiTimeline::find($id);
        $pecah = explode('.', $bukti->nama_file);
        $nama_file = strtolower(str_replace(' ', '_', $bukti->keterangan));

        // Path ke file di folder public
        $filePath = public_path('bukti_timeline/' . $bukti->nama_file);

        // Periksa apakah file ada
        if (!file_exists($filePath)) {
            Session::flash('error', 'File tidak ditemukan');

            return redirect()->back();
        }

        // Tentukan MIME type file
        $mimeType = mime_content_type($filePath);

        // Streaming file ke browser
        return response()->file($filePath, [
            'Content-Type' => $mimeType, // MIME type
            'Content-Disposition' => "inline; filename=\"$nama_file.$pecah[1]\"", // Agar file ditampilkan, bukan diunduh
        ]);
    }
}
