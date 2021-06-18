<?php

namespace App\Http\Controllers;

use App\Exports\ExportPelamar;
use App\Models\Interpretasi;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PelamarController extends Controller
{
    public function index()
    {
        // $pelamar = DB::table('pelamar')
        //     ->join('pelamar_summary', 'pelamar.ID_pelamar', '=', 'pelamar_summary.ID_pelamar')
        //     ->get();

        // return $pelamar;
        $jenjang = ['SMP', 'SMA/SMK', 'MA/Sederajat', 'D1', 'D2', 'D3', 'S1', 'S2', 'Informal'];
        $interpretasi = Interpretasi::get(['ID_interpretasi', 'judul']);
        return view('pages.pelamar.index', [
            'jenjang' => $jenjang,
            'interpretasi' => $interpretasi,
        ]);
    }

    public function detail($id)
    {
        $pelamar = Pelamar::whereIdPelamar($id)->firstOrFail();
        return view('pages.pelamar.detail', [
            'pelamar' => $pelamar,
        ]);
    }

    public function changeStatus($idPelamar)
    {
        $pelamar = Pelamar::findOrfail($idPelamar);
        if ($pelamar->status == 0) {
            $pelamar->update([
                'status' => 1,
            ]);
        } else if ($pelamar->status == 1) {
            $pelamar->update([
                'status' => 2,
            ]);
        }

        return redirect()->back();
    }

    public function dowloadFilePelamar($tipe, $kodePelamar)
    {
        $pelamar = Pelamar::whereKodePelamar($kodePelamar)->firstOrFail();
        $downloadFile = ($tipe == 'foto') ? $pelamar->foto_pelamar : (($tipe == 'ktp') ? $pelamar->ktp : (($tipe == 'sim') ? $pelamar->sim : (($tipe == 'document') ? $pelamar->document_lain : false)));
        return Storage::download($downloadFile);
    }

    public function exportEXCEL(Request $request)
    {
        $pelamar = Pelamar::with([]);
        $date = date_format(Date::now(), 'dmy');
        $exportName = "pelamar-$date.xlsx";

        if (auth()->user()->role == 'member') {
            $pelamar->whereIdMember(auth()->user()->ID_member);
        }
        if (!empty($request->status_menikah)) {
            $pelamar->whereStatusMenikah($request->status_menikah);
        }
        if (!empty($request->jenis_kelamin)) {
            $pelamar->whereJenisKelamin($request->jenis_kelamin);
        }

        return Excel::download(new ExportPelamar($pelamar->get()), $exportName);
        // return $pelamar->get(['status_menikah']);
    }

    public function exportPDF(Request $request)
    {
        $pelamar = Pelamar::with([]);

        if (auth()->user()->role == 'member') {
            $pelamar->whereIdMember(auth()->user()->ID_member);
        }
        if (!empty($request->status_menikah)) {
            $pelamar->whereStatusMenikah($request->status_menikah);
        }
        if (!empty($request->jenis_kelamin)) {
            $pelamar->whereJenisKelamin($request->jenis_kelamin);
        }

        $pdf = PDF::loadView('pages.pelamar.export-pdf', [
            'pelamar' => $pelamar->get(),
        ]);
        return $pdf->stream();
        // $pdf->download("daftar-pelamar-" . date("dmy") . ".pdf");
        // return $request->all();
    }

    public function datatables(Request $request)
    {
        $pelamar = DB::table('pelamar');
        $pelamar->join('lowongan', 'pelamar.ID_lowongan', '=', 'lowongan.ID_lowongan');
        $pelamar->join('pendidikan_pelamar', 'pelamar.ID_pelamar', '=', 'pendidikan_pelamar.ID_pelamar');

        if (auth()->user()->role == 'member') {
            $pelamar->where('pelamar.ID_member', '=', auth()->user()->ID_member);
        }
        if (!empty($request->interpretasi)) {
            $pelamar->join('pelamar_summary', 'pelamar.ID_pelamar', '=', 'pelamar_summary.ID_pelamar');
            $pelamar->join('interpretasi', 'pelamar_summary.ID_interpretasi', '=', 'interpretasi.ID_interpretasi');
            $pelamar->where('pelamar_summary.ID_interpretasi', '=', $request->interpretasi);
        }
        if (!empty($request->jenjang)) {
            $pelamar->where('pendidikan_pelamar.jenjang', '=', $request->jenjang);
        }
        if ($request->status_menikah != null) {
            $pelamar->where('pelamar.status_menikah', '=', $request->status_menikah);
        }
        if ($request->jenis_kelamin != null) {
            $pelamar->where('pelamar.jenis_kelamin', '=', $request->jenis_kelamin);
        }

        return DataTables::of($pelamar->get(['nama_pelamar', 'label', 'jenjang', 'jenis_kelamin', 'status_menikah', 'alamat', 'status']))
            ->addIndexColumn()
            ->toJson();
    }
}
