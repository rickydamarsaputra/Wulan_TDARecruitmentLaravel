<?php

namespace App\Http\Controllers;

use App\Exports\ExportPelamar;
use App\Models\Interpretasi;
use App\Models\Pelamar;
use App\Models\PelamarSummary;
use App\Models\PendidikanPelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PelamarController extends Controller
{
    public function getTitleInterpretasi($idPelamar)
    {
        $pelamarSummary = PelamarSummary::where('ID_pelamar', $idPelamar)->first(['ID_interpretasi']);
        if ($pelamarSummary != null) {
            $interpretasi = Interpretasi::where('ID_interpretasi', $pelamarSummary->ID_interpretasi)->first(['judul']);
            return $interpretasi;
        } else {
            return '-';
        }
    }

    public function getJenjang($idPelamar)
    {
        $jenjang = PendidikanPelamar::where('ID_pelamar', $idPelamar)->get(['jenjang']);
        return $jenjang;
    }

    public function index()
    {
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

        $pelamar->join('pendidikan_pelamar', 'pelamar.ID_pelamar', '=', 'pendidikan_pelamar.ID_pelamar');

        if (auth()->user()->role == 'member') {
            $pelamar->whereIdMember(auth()->user()->ID_member);
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

        // return $pelamar->get()->unique("ID_pelamar");
        return Excel::download(new ExportPelamar($pelamar->get()->unique("ID_pelamar")), $exportName);
    }

    public function exportPDF(Request $request)
    {
        $pelamar = Pelamar::with([]);
        $pelamar->join('pendidikan_pelamar', 'pelamar.ID_pelamar', '=', 'pendidikan_pelamar.ID_pelamar');

        if (auth()->user()->role == 'member') {
            $pelamar->whereIdMember(auth()->user()->ID_member);
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

        $pdf = PDF::loadView('pages.pelamar.export-pdf', [
            'pelamar' => $pelamar->get()->unique("ID_pelamar"),
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

        return DataTables::of($pelamar->get(['pelamar.ID_pelamar', 'nama_pelamar', 'label', 'jenis_kelamin', 'status_menikah', 'alamat', 'status'])->unique("ID_pelamar"))
            ->addIndexColumn()
            ->addColumn('nama_and_id', function ($pelamar) {
                return [$pelamar->nama_pelamar, $pelamar->ID_pelamar];
            })
            ->addColumn('disc', function ($pelamar) {
                return $this->getTitleInterpretasi($pelamar->ID_pelamar);
            })
            ->addColumn('jenjang', function ($pelamar) {
                return $this->getJenjang($pelamar->ID_pelamar);
            })
            ->toJson();
    }
}
