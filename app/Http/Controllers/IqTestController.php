<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\SoalOpsi;
use App\Models\TestIQ;
use App\Models\TestIQItem;
use Illuminate\Http\Request;
use DataTables;

use function PHPUnit\Framework\returnSelf;

class IqTestController extends Controller
{
    public function index($idPelamar, $kodePelamar)
    {
        return view('pages.public.perusahaan.iq-test', [
            'titlePage' => 'Test IQ',
            'idPelamar' => $idPelamar,
            'kodePelamar' => $kodePelamar,
        ]);
    }

    public function questionView($idPelamar, $kodePelamar, $questionNumber)
    {
        if ($questionNumber > 70) {
            return response()->json([
                'message' => 'test IQ telah selesai',
            ]);
        }

        $testIQ = TestIQ::where('ID_pelamar', '=', $idPelamar)->first();
        if (empty($testIQ)) {
            $testIQ = TestIQ::create([
                'ID_pelamar' => $idPelamar,
                'mulai_tes' => time(),
                'lama_mengerjakan' => 0,
            ]);
        }

        $testIQItem = TestIQItem::where('ID_tiq', '=', $testIQ->ID_tiq)->get(['ID_tiq_soal']);
        $idSoal = [];
        foreach ($testIQItem as $loop) {
            $idSoal[] = $loop->ID_tiq_soal;
        }

        $testIQItemClear = TestIQItem::where('ID_tiq', '=', $testIQ->ID_tiq)->where('nomor', '=', $questionNumber)->first();
        if ($testIQItemClear) {
            return redirect()->route('perusahaan.pelamar.test.iq.question.view', ['idPelamar' => $idPelamar, 'kodePelamar' => $kodePelamar, 'questionNumber' => $questionNumber + 1]);
        }

        $soal = Soal::with('opsi')->inRandomOrder();

        if (!empty($idSoal)) {
            $soal->whereNotIn('ID_tiq_soal', $idSoal);
        }

        if (empty($soal->first())) {
            return response()->json([
                'message' => 'soal habis',
            ]);
        }

        return view('pages.public.perusahaan.iq-test-question', [
            'titlePage' => 'Test IQ Soal',
            'idPelamar' => $idPelamar,
            'kodePelamar' => $kodePelamar,
            'questionNumber' => $questionNumber,
            'soal' => $soal->first(),
        ]);
    }

    public function questionProcess(Request $request, $idPelamar, $kodePelamar, $questionNumber)
    {
        // return $request->all();
        $testIQ = TestIQ::where('ID_pelamar', '=', $idPelamar)->first();
        if (empty($testIQ)) {
            $testIQ = TestIQ::create([
                'ID_pelamar' => $idPelamar,
                'mulai_tes' => time(),
                'lama_mengerjakan' => 0,
            ]);
        }

        if ($questionNumber != 71) {
            $testSoal = Soal::where('ID_tiq_soal', '=', $request->ID_tiq_soal)->first();
            $testIQItem = TestIQItem::create([
                'ID_tiq' => $testIQ->ID_tiq,
                'ID_tiq_soal' => $testSoal->ID_tiq_soal,
                'nomor' => $questionNumber,
                'jawaban' => $request->ID_tiq_opsi,
                'poin' => 0,
            ]);

            if ($request->ID_tiq_opsi == $testSoal->jawaban_benar) {
                $testIQItemUpdate = TestIQItem::where('ID_tiq_item', '=', $testIQItem->ID_tiq_item)->update([
                    'poin' => $testSoal->poin_benar,
                ]);
            }
        }

        if ($questionNumber == 70 || $questionNumber > 70) {
            $testIQ->update([
                'lama_mengerjakan' => $request->time,
            ]);
            return redirect()->route('perusahaan.pelamar.result.page.view', ['idPelamar' => $idPelamar, 'kodePelamar' => $kodePelamar]);
        };
        return redirect()->route('perusahaan.pelamar.test.iq.question.view', ['idPelamar' => $idPelamar, 'kodePelamar' => $kodePelamar, 'questionNumber' => $questionNumber + 1]);
    }

    public function questionIndex()
    {
        return view('pages.iq-question.index');
    }

    public function questionCreateView()
    {
        return view('pages.iq-question.create');
    }

    public function questionCreateProcess(Request $request)
    {
        $soal = Soal::create([
            'desc_soal' => $request->deskripsi_soal,
            'jawaban_benar' => 0,
            'poin_benar' => $request->poin_benar
        ]);

        foreach ($request->opsi_text as $index => $opsi) {
            $opsi = SoalOpsi::create([
                'ID_tiq_soal' => $soal->ID_tiq_soal,
                'desc_opsi' => $opsi
            ]);

            if ($index == $request->opsi_jawaban) {
                $soal->update([
                    'jawaban_benar' => $opsi->ID_tiq_opsi
                ]);
            }
        }
        return redirect()->back();
    }

    public function datatables()
    {
        $question = Soal::get();

        return DataTables::of($question)
            ->addIndexColumn()
            ->toJson();
    }
}
