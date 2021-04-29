<?php

namespace App\Http\Controllers;

use App\Jobs\TdaSendMail;
use App\Models\Gambaran;
use App\Models\Interpretasi;
use App\Models\Lowongan;
use App\Models\Member;
use App\Models\Pelamar;
use App\Models\PelamarGambaran;
use App\Models\PelamarSummary;
use App\Models\PendidikanPelamar;
use App\Models\PengalamanKerja;
use App\Models\PengalamanOrganisasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    public function PerusahaanPelamarFormView($kodeMember)
    {
        $member = Member::with(['lowongan'])->whereKodeMember($kodeMember)->firstOrFail();
        $lowongan = Lowongan::whereIdMember($member->ID_member)->whereStatusAktif(1)->get(['ID_lowongan', 'label']);

        if (count($lowongan) <= 0) {
            return redirect()->route('perusahaan.not.found.lowongan', $member->kode_member);
        } else {
            return view('pages.public.perusahaan.index', [
                'titlePage' => $member->nama_bisnis,
                'member' => $member,
                'lowongan' => $lowongan,
            ]);
        }
    }

    public function notFoundLowongan($kodeMember)
    {
        $member = Member::whereKodeMember($kodeMember)->first();

        return view('pages..public.perusahaan.sorry', [
            'namaBisnis' => $member->nama_bisnis,
        ]);
    }

    public function PerusahaanPelamarFormProcess(Request $request, $kodeMember)
    {
        // return $request->only(['status_menikah', 'gaji_terakhir', 'gaji_ekspetasi']);
        $member = Member::whereKodeMember($kodeMember)->firstOrFail();
        $admin = User::where('role', '=', 'admin')->get();
        $pelamarNama = Str::slug($request->nama);
        $date = date_format(Date::now(), 'dmy');

        $this->validate($request, [
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'alamat' => 'required',
            'pelamar_ktp' => 'required',
            'foto_pelamar' => 'required',
            'email' => 'required',
            'no_telp_1' => 'required',
        ]);

        $pelamarKtpFileExtension = $request->file('pelamar_ktp')->getClientOriginalExtension();
        $pelamarKtpFileName = "ktp-$pelamarNama-$date.$pelamarKtpFileExtension";

        $pelamarSimFileExtension = empty($request->file('pelamar_sim')) ? null : $request->file('pelamar_sim')->getClientOriginalExtension();
        $pelamarSimFileName = empty($pelamarSimFileExtension) ? null : "sim-$pelamarNama-$date.$pelamarSimFileExtension";

        $pelamarDocumentLainFileExtension = empty($request->file('document_lain')) ? null : $request->file('document_lain')->getClientOriginalExtension();
        $pelamarDocumentLainFileName = empty($pelamarDocumentLainFileExtension) ? null : "document-lain-$pelamarNama-$date.$pelamarDocumentLainFileExtension";

        $pelamarFotoFileExtension = $request->file('foto_pelamar')->getClientOriginalExtension();
        $pelamarFotoFileName = "foto-pelamar-$pelamarNama-$date.$pelamarFotoFileExtension";

        $pathPelamarKtpFile = Storage::putFileAs('pelamar-ktp-file', $request->file('pelamar_ktp'), $pelamarKtpFileName);
        $pathPelamarSimFile = empty($pelamarSimFileName) ? null : Storage::putFileAs('pelamar-sim-file', $request->file('pelamar_sim'), $pelamarSimFileName);
        $pathPelamarDocumentLainFile = empty($pelamarDocumentLainFileName) ? null : Storage::putFileAs('pelamar-document-lain-file', $request->file('document_lain'), $pelamarDocumentLainFileName);
        $pathPelamarFotoFile = Storage::putFileAs('pelamar-foto', $request->file('foto_pelamar'), $pelamarFotoFileName);

        $pelamar = Pelamar::create([
            'ID_lowongan' => $request->id_lowongan,
            'ID_member' => $member->ID_member,
            'nama_pelamar' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'kode_pelamar' => Str::slug($request->nama),
            'keterangan' => '-',
            'ktp' => $pathPelamarKtpFile,
            'sim' => $pathPelamarSimFile,
            'document_lain' => $pathPelamarDocumentLainFile,
            'foto_pelamar' => $pathPelamarFotoFile,
            'email' => $request->email,
            'web_blog' => empty($request->web_blog) ? null : $request->web_blog,
            'no_hp1' => $request->no_telp_1,
            'no_hp2' => empty($request->no_telp_2) ? null : $request->no_telp_2,
            'username_ig' => empty($request->username_ig) ? null : $request->username_ig,
            'link_facebook' => empty($request->link_facebook) ? null : $request->link_facebook,
            'username_tw' => empty($request->username_tw) ? null : $request->username_tw,
            'link_youtube' => empty($request->link_youtube) ? null : $request->link_youtube,
            'status_menikah' => $request->status_menikah,
            'gaji_terakhir' => $request->gaji_terakhir,
            'gaji_ekspektasi' => $request->gaji_ekspektasi,
            'status' => 0,
        ]);

        $counterPendidikan = 0;
        $pendidikanPelamar = [];
        $pendidikanPelamarTahunAwal = $request->tahun_awal_pendidikan;
        $pendidikanPelamarTahunAkhir = $request->tahun_akhir_pendidikan;
        $pendidikanPelamarNamaInstitusi = $request->nama_institusi_pendidikan;
        $pendidikanPelamarNamaJurusan = $request->nama_jurusan_pendidikan;

        $counterPengalamanKerja = 0;
        $pengalamanKerja = [];
        $pengalamanKerjaTahunAwal = $request->tahun_awal_pengalaman_kerja;
        $pengalamanKerjaTahunAkhir = $request->tahun_akhir_pengalaman_kerja;
        $pengalamanKerjaNamaPerusahaan = $request->nama_perusahaan;
        $pengalamanKerjaNamaPosisi = $request->nama_posisi;
        $pengalamanKerjaDeskripsiTanggungJawab = $request->deskripsi_tanggung_jawab;

        $counterPengalamanOrganisasi = 0;
        $pengalamanOrganisasi = [];
        $pengalamanOrganisasiTahunAwal = $request->tahun_awal_pengalaman_organisasi;
        $pengalamanOrganisasiTahunAkhir = $request->tahun_akhir_pengalaman_organisasi;
        $pengalamanOrganisasiNamaOrganisasi = $request->nama_organisasi;
        $pengalamanOrganisasiNamaPosisiOrganisasi = $request->nama_posisi_organisasi;
        $pengalamanOrganisasiDeskripsi = $request->deskripsi_pengalaman_organisasi;

        foreach ($pendidikanPelamarTahunAwal as $loopItem) {
            array_push($pendidikanPelamar, [
                'tahun_awal' => $pendidikanPelamarTahunAwal[$counterPendidikan],
                'tahun_akhir' => $pendidikanPelamarTahunAkhir[$counterPendidikan],
                'institusi' => $pendidikanPelamarNamaInstitusi[$counterPendidikan],
                'jurusan' => $pendidikanPelamarNamaJurusan[$counterPendidikan],
            ]);
            $counterPendidikan++;
        }

        foreach ($pengalamanKerjaTahunAwal as $loopItem) {
            array_push($pengalamanKerja, [
                'tahun_awal' => $pengalamanKerjaTahunAwal[$counterPengalamanKerja],
                'tahun_akhir' => $pengalamanKerjaTahunAkhir[$counterPengalamanKerja],
                'perusahaan' => $pengalamanKerjaNamaPerusahaan[$counterPengalamanKerja],
                'posisi' => $pengalamanKerjaNamaPosisi[$counterPengalamanKerja],
                'deskripsi' => $pengalamanKerjaDeskripsiTanggungJawab[$counterPengalamanKerja],
            ]);
            $counterPengalamanKerja++;
        }

        foreach ($pengalamanOrganisasiTahunAwal as $loopItem) {
            array_push($pengalamanOrganisasi, [
                'tahun_awal' => $pengalamanOrganisasiTahunAwal[$counterPengalamanOrganisasi],
                'tahun_akhir' => $pengalamanOrganisasiTahunAkhir[$counterPengalamanOrganisasi],
                'organisasi' => $pengalamanOrganisasiNamaOrganisasi[$counterPengalamanOrganisasi],
                'posisi' => $pengalamanOrganisasiNamaPosisiOrganisasi[$counterPengalamanOrganisasi],
                'deskripsi' => $pengalamanOrganisasiDeskripsi[$counterPengalamanOrganisasi],
            ]);
            $counterPengalamanOrganisasi++;
        }

        foreach ($pendidikanPelamar as $loopItem) {
            $pendidikanPelamarInsertToDatabase = PendidikanPelamar::create([
                'ID_pelamar' => $pelamar->ID_pelamar,
                'institusi' => empty($loopItem['institusi']) ? null : $loopItem['institusi'],
                'jurusan' => empty($loopItem['jurusan']) ? null : $loopItem['jurusan'],
                'tahun_awal' => empty($loopItem['tahun_awal']) ? null : $loopItem['tahun_awal'],
                'tahun_akhir' => empty($loopItem['tahun_akhir']) ? null : $loopItem['tahun_akhir'],
            ]);
        }

        foreach ($pengalamanKerja as $loopItem) {
            $pengalamanKerjaInsertToDatabase = PengalamanKerja::create([
                'ID_pelamar' => $pelamar->ID_pelamar,
                'perusahaan' => empty($loopItem['perusahaan']) ? null : $loopItem['perusahaan'],
                'posisi' => empty($loopItem['posisi']) ? null : $loopItem['posisi'],
                'tahun_awal' => empty($loopItem['tahun_awal']) ? null : $loopItem['tahun_awal'],
                'tahun_akhir' => empty($loopItem['tahun_akhir']) ? null : $loopItem['tahun_akhir'],
                'deskripsi' => empty($loopItem['deskripsi']) ? null : $loopItem['deskripsi'],
            ]);
        }

        foreach ($pengalamanOrganisasi as $loopItem) {
            $pengalamanOrganisasiInsertToDatabase = PengalamanOrganisasi::create([
                'ID_pelamar' => $pelamar->ID_pelamar,
                'organisasi' => empty($loopItem['organisasi']) ? null : $loopItem['organisasi'],
                'posisi' => empty($loopItem['posisi']) ? null : $loopItem['posisi'],
                'tahun_awal' => empty($loopItem['tahun_awal']) ? null : $loopItem['tahun_awal'],
                'tahun_akhir' => empty($loopItem['tahun_akhir']) ? null : $loopItem['tahun_akhir'],
                'deskripsi' => empty($loopItem['deskripsi']) ? null : $loopItem['deskripsi'],
            ]);
        }

        // $dateAndTime = date_format(Date::now(), 'd F Y H:i:s');

        // $message = $pelamar->lowongan->custom_message;
        // $message = str_replace(['[namaPelamar]', '[namaPerusahaan]'], [$pelamar->nama_pelamar, $pelamar->member->nama_bisnis], $message);

        // $sendEmailToPelamar = TdaSendMail::dispatch([
        //     'email' => $pelamar->email,
        //     'message' => $message,
        //     'kodePelamar' => null,
        // ]);

        // $memberMessage = "Pelamar baru berhasil mengirim lamaran pekerjaan melalui aplikasi Rekrutmen TDA untuk lowongan [namaLowongan] pada $dateAndTime.";
        // $memberMessage = str_replace(['[namaLowongan]'], [$pelamar->lowongan->label], $memberMessage);
        // $sendEmailToMember = TdaSendMail::dispatch([
        //     'email' => $member->user->email,
        //     'message' => $memberMessage,
        //     'kodePelamar' => $pelamar->kode_pelamar,
        // ]);

        // $adminMessage = "Pelamar baru berhasil mengirim lamaran pekerjaan melalui aplikasi Rekrutmen TDA untuk lowongan [namaLowongan] kepada [namaPerusahaan] (member [namaMember]), pada $dateAndTime.";
        // $adminMessage = str_replace(['[namaLowongan]', '[namaPerusahaan]', '[namaMember]'], [$pelamar->lowongan->label, $pelamar->member->nama_bisnis, $pelamar->member->nama_member], $adminMessage);
        // foreach ($admin as $loopItem) {
        //     $sendEmailToAdmin = TdaSendMail::dispatch([
        //         'email' => $loopItem->email,
        //         'message' => $adminMessage,
        //         'kodePelamar' => $pelamar->kode_pelamar,
        //     ]);
        // }

        return redirect()->route('perusahaan.pelamar.test.disc.view', $pelamar->kode_pelamar);
        // return redirect()->route('perusahaan.pelamar.result.page.view', $pelamar->kode_pelamar);
    }

    public function discTestView($kodePelamar)
    {
        $gambaran = Gambaran::get(['ID_gambaran', 'no_soal', 'deskripsi', 'kunci_m', 'kunci_l']);
        $pelamar = Pelamar::whereKodePelamar($kodePelamar)->first();

        return view('pages.public.perusahaan.disc', [
            'titlePage' => 'Test DISC',
            'gambaran' => $gambaran,
            'pelamar' => $pelamar,
        ]);
    }

    public function discTestProcess(Request $request, $kodePelamar)
    {
        $counter = 0;
        $discPelamar = [];
        $pelamar = Pelamar::whereKodePelamar($kodePelamar)->first();

        foreach ($request->nomor_soal as $loopItem) {
            array_push($discPelamar, [
                'ID_pelamar' => $pelamar->ID_pelamar,
                'no_soal' => $loopItem,
            ]);

            foreach ($request->only(["gambaran_no_$loopItem"]) as $loopItem) {
                $discPelamar[$counter]['ID_gambaran_m'] = $loopItem[0];
                $discPelamar[$counter]['ID_gambaran_l'] = $loopItem[1];
            }

            $counter++;
        }

        foreach ($discPelamar as $loopItem) {
            $pelamarGambaran = PelamarGambaran::create([
                'ID_pelamar' => $loopItem['ID_pelamar'],
                'no_soal' => $loopItem['no_soal'],
                'ID_gambaran_m' => $loopItem['ID_gambaran_m'],
                'ID_gambaran_l' => $loopItem['ID_gambaran_l'],
            ]);
        }

        function shortArryDESC($args)
        {
            usort($args, function ($a, $b) {
                return $a['nilai'] <= $b['nilai'];
            });
            return $args;
        }

        $mostD = PelamarGambaran::whereIdPelamar($pelamar->ID_pelamar)->whereIdGambaranM(1)->count();
        $mostI = PelamarGambaran::whereIdPelamar($pelamar->ID_pelamar)->whereIdGambaranM(2)->count();
        $mostS = PelamarGambaran::whereIdPelamar($pelamar->ID_pelamar)->whereIdGambaranM(3)->count();
        $mostC = PelamarGambaran::whereIdPelamar($pelamar->ID_pelamar)->whereIdGambaranM(4)->count();
        $mostST = PelamarGambaran::whereIdPelamar($pelamar->ID_pelamar)->whereIdGambaranM(5)->count();

        $leastD = PelamarGambaran::whereIdPelamar($pelamar->ID_pelamar)->whereIdGambaranL(1)->count();
        $leastI = PelamarGambaran::whereIdPelamar($pelamar->ID_pelamar)->whereIdGambaranL(2)->count();
        $leastS = PelamarGambaran::whereIdPelamar($pelamar->ID_pelamar)->whereIdGambaranL(3)->count();
        $leastC = PelamarGambaran::whereIdPelamar($pelamar->ID_pelamar)->whereIdGambaranL(4)->count();
        $leastST = PelamarGambaran::whereIdPelamar($pelamar->ID_pelamar)->whereIdGambaranL(5)->count();

        $changeD = $mostD - $leastD;
        $changeI = $mostI - $leastI;
        $changeS = $mostS - $leastS;
        $changeC = $mostC - $leastC;

        $most = [
            [
                'disc' => 'D',
                'nilai' => $mostD,
            ],
            [
                'disc' => 'I',
                'nilai' => $mostI,
            ],
            [
                'disc' => 'S',
                'nilai' => $mostS,
            ],
            [
                'disc' => 'C',
                'nilai' => $mostC,
            ],
            [
                'disc' => 'ST',
                'nilai' => $mostST,
            ],
        ];
        $least = [
            [
                'disc' => 'D',
                'nilai' => $leastD,
            ],
            [
                'disc' => 'I',
                'nilai' => $leastI,
            ],
            [
                'disc' => 'S',
                'nilai' => $leastS,
            ],
            [
                'disc' => 'C',
                'nilai' => $leastC,
            ],
            [
                'disc' => 'ST',
                'nilai' => $leastST,
            ],
        ];
        $change = [
            [
                'disc' => 'D',
                'nilai' => $changeD,
            ],
            [
                'disc' => 'I',
                'nilai' => $changeI,
            ],
            [
                'disc' => 'S',
                'nilai' => $changeS,
            ],
            [
                'disc' => 'C',
                'nilai' => $changeC,
            ],
        ];

        $pelamarSummary = PelamarSummary::create([
            'ID_pelamar' => $pelamar->ID_pelamar,
            'ID_interpretasi' => 0,
            'm_d' => $mostD,
            'm_i' => $mostI,
            'm_s' => $mostS,
            'm_c' => $mostC,
            'm_st' => $mostST,
            'l_d' => $leastD,
            'l_i' => $leastI,
            'l_s' => $leastS,
            'l_c' => $leastC,
            'l_st' => $leastST,
            'c_d' => $changeD,
            'c_i' => $changeI,
            'c_s' => $changeS,
            'c_c' => $changeC,
        ]);
        $shortMost = shortArryDESC($most);
        $interpretasi = Interpretasi::whereDominan_1($shortMost[0]['disc'] != 'ST' ? $shortMost[0]['disc'] : null)->whereDominan_2($shortMost[1]['disc'] != 'ST' ? $shortMost[1]['disc'] : null)->whereDominan_3($shortMost[2]['disc'] != 'ST' ? $shortMost[2]['disc'] : null)->first();

        $pelamarSummary = PelamarSummary::whereIdPelamar($pelamar->ID_pelamar)->first();
        $pelamarSummary->update([
            'ID_interpretasi' => empty($interpretasi->ID_interpretasi) ? 0 :  $interpretasi->ID_interpretasi,
        ]);

        return redirect()->route('perusahaan.thank.you');
        // return redirect()->route('perusahaan.pelamar.test.disc.result', $pelamar->kode_pelamar);
        // return [
        //     'most' => [
        //         shortArryDESC($most)[0],
        //         shortArryDESC($most)[1],
        //         shortArryDESC($most)[2],
        //     ],
        //     'least' =>  [
        //         shortArryDESC($least)[0],
        //         shortArryDESC($least)[1],
        //         shortArryDESC($least)[2],
        //     ],
        //     'change' =>  [
        //         shortArryDESC($change)[0],
        //         shortArryDESC($change)[1],
        //         shortArryDESC($change)[2],
        //     ],
        // ];
        // return PelamarGambaran::whereIdPelamar($pelamar->ID_pelamar)->whereIdGambaranM(2)->get()->count();
    }

    public function discTestResult($kodePelamar)
    {
        $pelamar = Pelamar::whereKodePelamar($kodePelamar)->first();
        $pelamarSummary = PelamarSummary::whereIdPelamar($pelamar->ID_pelamar)->first();
        $mostDISC = PelamarSummary::whereIdPelamar($pelamar->ID_pelamar)->first(['m_d', 'm_i', 'm_s', 'm_c', 'm_st']);
        $leastDISC = PelamarSummary::whereIdPelamar($pelamar->ID_pelamar)->first(['l_d', 'l_i', 'l_s', 'l_c', 'l_st']);
        $changeDISC = PelamarSummary::whereIdPelamar($pelamar->ID_pelamar)->first(['c_d', 'c_i', 'c_s', 'c_c']);

        return view('pages.public.perusahaan.disc-result', [
            'titlePage' => 'Result Test DISC',
            'pelamar' => $pelamar,
            'pelamarSummary' => $pelamarSummary,
            'mostDISC' => json_encode([$mostDISC->m_d, $mostDISC->m_i, $mostDISC->m_s, $mostDISC->m_c]),
            'leastDISC' => json_encode([$leastDISC->l_d, $leastDISC->l_i, $leastDISC->l_s, $leastDISC->l_c]),
            'changeDISC' => json_encode([$changeDISC->c_d, $changeDISC->c_i, $changeDISC->c_s, $changeDISC->c_c]),
        ]);
    }

    public function perusahaanPelamarResultPage($kodePelamar)
    {
        $pelamar = Pelamar::whereKodePelamar($kodePelamar)->firstOrFail();

        $message = $pelamar->lowongan->custom_message;
        $message = str_replace(['[namaPelamar]', '[namaPerusahaan]'], [$pelamar->nama_pelamar, $pelamar->member->nama_bisnis], $message);

        return view('pages.public.perusahaan.result', [
            'titlePage' => $pelamar->nama_pelamar,
            'pelamar' => $pelamar,
            'message' => $message,
        ]);
    }
}
