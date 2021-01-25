<?php

namespace App\Http\Controllers;

use App\Jobs\TdaSendMail;
use App\Models\Lowongan;
use App\Models\Member;
use App\Models\Pelamar;
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

        return view('pages.public.perusahaan.index', [
            'titlePage' => $member->nama_bisnis,
            'member' => $member,
            'lowongan' => $lowongan,
        ]);
    }

    public function PerusahaanPelamarFormProcess(Request $request, $kodeMember)
    {
        $member = Member::whereKodeMember($kodeMember)->firstOrFail();
        $admin = User::where('role', '=', 'admin')->get();
        $pelamarNama = Str::slug($request->nama);
        $date = date_format(Date::now(), 'dmy');

        $this->validate($request, [
            'nama' => 'required',
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

        $dateAndTime = date_format(Date::now(), 'd F Y H:i:s');

        $message = $pelamar->lowongan->custom_message;
        $message = str_replace(['[namaPelamar]', '[namaPerusahaan]'], [$pelamar->nama_pelamar, $pelamar->member->nama_bisnis], $message);

        $sendEmailToPelamar = TdaSendMail::dispatch([
            'email' => $pelamar->email,
            'message' => $message,
            'kodePelamar' => null,
        ]);

        $memberMessage = "Pelamar baru berhasil mengirim lamaran pekerjaan melalui aplikasi Rekrutmen TDA untuk lowongan [namaLowongan] pada $dateAndTime.";
        $memberMessage = str_replace(['[namaLowongan]'], [$pelamar->lowongan->label], $memberMessage);
        $sendEmailToMember = TdaSendMail::dispatch([
            'email' => $member->user->email,
            'message' => $memberMessage,
            'kodePelamar' => $pelamar->kode_pelamar,
        ]);

        $adminMessage = "Pelamar baru berhasil mengirim lamaran pekerjaan melalui aplikasi Rekrutmen TDA untuk lowongan [namaLowongan] kepada [namaPerusahaan] (member [namaMember]), pada $dateAndTime.";
        $adminMessage = str_replace(['[namaLowongan]', '[namaPerusahaan]', '[namaMember]'], [$pelamar->lowongan->label, $pelamar->member->nama_bisnis, $pelamar->member->nama_member], $adminMessage);
        foreach ($admin as $loopItem) {
            $sendEmailToAdmin = TdaSendMail::dispatch([
                'email' => $loopItem->email,
                'message' => $adminMessage,
                'kodePelamar' => $pelamar->kode_pelamar,
            ]);
        }

        return redirect()->route('perusahaan.pelamar.result.page.view', $pelamar->kode_pelamar);
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
