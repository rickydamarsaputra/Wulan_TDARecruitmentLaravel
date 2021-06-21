<table>
  <thead>
    <tr>
      <th>#</th>
      <th>nama pelamar</th>
      <th>agama</th>
      <th>kode pelamar</th>
      <th>nama lowongan</th>
      <th>jenis kelamin</th>
      <th>alamat</th>
      <th>tempat lahir</th>
      <th>tanggal lahir</th>
      <th>email</th>
      <th>web blog</th>
      <th>no hp 1</th>
      <th>no hp 2</th>
      <th>username ig</th>
      <th>link facebook</th>
      <th>username tw</th>
      <th>link youtube</th>
      <th>status menikah</th>
      <th>gaji terakhir</th>
      <th>gaji ekspetasi</th>
      <th>foto</th>
      <th>ktp</th>
      <th>sim</th>
      <th>document lain</th>
      <th>pendidikan</th>
      <th>pengalaman kerja</th>
      <th>pengalaman organisasi</th>
      <th>Hasil Test DISC</th>
    </tr>
  </thead>
  <tbody>
    @foreach($pelamar as $loopItem)
    <tr>
      <td>{{$loop->iteration}}</td>
      <td>{{$loopItem->nama_pelamar}}</td>
      <td>{{!empty($loopItem->agama) ? $loopItem->agama : '-'}}</td>
      <td>{{$loopItem->kode_pelamar}}</td>
      <td>{{$loopItem->lowongan->label}}</td>
      <td>{{$loopItem->jenis_kelamin}}</td>
      <td>{{$loopItem->alamat}}</td>
      <td>{{$loopItem->tempat_lahir}}</td>
      <td>{{$loopItem->tanggal_lahir}}</td>
      <td>{{$loopItem->email}}</td>
      <td>{{$loopItem->web_blog}}</td>
      <td>{{$loopItem->no_hp1}}</td>
      <td>{{empty($loopItem->no_hp2) ? '-' : $loopItem->no_hp2}}</td>
      <td>{{empty($loopItem->username_ig) ? '-' : $loopItem->username_ig}}</td>
      <td>{{empty($loopItem->link_facebook) ? '-' : $loopItem->link_facebook}}</td>
      <td>{{empty($loopItem->username_tw) ? '-' : $loopItem->username_tw}}</td>
      <td>{{empty($loopItem->link_youtube) ? '-' : $loopItem->link_youtube}}</td>
      <td>{{$loopItem->status_menikah == 1 ? 'sudah' : 'belum'}}</td>
      <td>{{empty($loopItem->gaji_terakhir) ? '-' : $loopItem->gaji_terakhir}}</td>
      <td>{{empty($loopItem->gaji_ekspetasi) ? '-' : $loopItem->gaji_ekspetasi}}</td>
      <td><a href="{{route('pelamar.download.file', ['tipe' => 'foto', 'kodePelamar' => $loopItem->kode_pelamar])}}" target="blank">download foto</a></td>
      <td><a href="{{route('pelamar.download.file', ['tipe' => 'ktp', 'kodePelamar' => $loopItem->kode_pelamar])}}" target="blank">download ktp</a></td>
      <td>
        @if(!empty($loopItem->sim))
        <a href="{{route('pelamar.download.file', ['tipe' => 'sim', 'kodePelamar' => $loopItem->kode_pelamar])}}" target="blank">download sim pelamar</a>
        @else
        -
        @endif
      </td>
      <td>
        @if(!empty($loopItem->document_lain))
        <a href="{{route('pelamar.download.file', ['tipe' => 'document', 'kodePelamar' => $loopItem->kode_pelamar])}}" target="blank">download document lain</a>
        @else
        -
        @endif
      </td>
      <td>
        @foreach($loopItem->pendidikanPelamar as $pendidikan)
        {{!$loop->last ? "$pendidikan->tahun_awal ~ $pendidikan->tahun_akhir - $pendidikan->jenjang - $pendidikan->jurusan - $pendidikan->institusi |" : "$pendidikan->tahun_awal ~ $pendidikan->tahun_akhir - $pendidikan->jenjang - $pendidikan->jurusan - $pendidikan->institusi"}}
        @endforeach
      </td>
      <td>
        @foreach($loopItem->pengalamanKerja as $kerja)
        {{!$loop->last ? "$kerja->perusahaan - $kerja->posisi |" : "$kerja->perusahaan - $kerja->posisi"}}
        @endforeach
      </td>
      <td>
        @foreach($loopItem->pengalamanOrganisasi as $organisasi)
        {{!$loop->last ? "$organisasi->organisasi - $organisasi->posisi |" : "$organisasi->organisasi - $organisasi->posisi"}}
        @endforeach
      </td>
      <td>{{!empty($loopItem->summary) ? str_replace("Profile: ", "", $loopItem->summary->interpretasi->judul) : '-'}}</td>
    </tr>
    @endforeach
  </tbody>
</table>