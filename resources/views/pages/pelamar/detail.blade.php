@extends('layout.dashboard')
@section('title', 'Pelamar Detail')

@section('content')
<section class="section">
  <div class="section-header text-capitalize d-flex justify-content-between">
    <h1>pelamar detail</h1>
    <div>
      <a href="{{route('lowongan.detail', $pelamar->lowongan->ID_lowongan)}}" class="btn btn-primary mr-2">kembali</a>
      @if($pelamar->summary)
      <a href="{{route('perusahaan.pelamar.test.disc.result', [$pelamar->ID_pelamar, $pelamar->kode_pelamar])}}" class="btn btn-info mr-2" target="blank">detail test DISC</a>
      @else
      <a href="{{route('perusahaan.pelamar.test.disc.view', [$pelamar->ID_pelamar, $pelamar->kode_pelamar])}}" class="btn btn-danger mr-2" target="blank">lakukan test DISC</a>
      @endif
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-lg tda__pelamar__info">
          <h6>profile <span>pelamar</span></h6>
          <p>status test DISC <span class="badge badge-status {{$pelamar->summary ? 'badge-success' : 'badge-danger'}}">{{$pelamar->summary ? 'sudah' : 'belum'}}</span></p>
          @if(!$pelamar->summary)
          <p>link test DISC</p>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text copy__button" data-clipboard-target="#tda__url__recruitment">
                <i class="far fa-copy"></i>
              </span>
            </div>
            <input type="text" class="form-control" id="tda__url__recruitment" value="{{route('perusahaan.pelamar.test.disc.view', [$pelamar->ID_pelamar, $pelamar->kode_pelamar])}}" readonly>
          </div>
          @endif
          <p>nama pelamar <span>{{$pelamar->nama_pelamar}}</span></p>
          <p>jenis kelamin <span>{{$pelamar->jenis_kelamin != 'laki_laki' ? 'Perempuan' : 'Laki - Laki'}}</span></p>
          <p>alamat <span>{{$pelamar->alamat}}</span></p>
          <p>agama <span>{{!empty($pelamar->agama) ? $pelamar->agama : '-'}}</span></p>
          <p>email <span>{{$pelamar->email}}</span></p>
          <p>web blog <span>{{$pelamar->web_blog ?? '-'}}</span></p>
          <p>no telp pertama <span><a href="https://wa.me/{{$pelamar->no_hp1}}" target="_blank">{{'0' . substr($pelamar->no_hp1, 2)}}</a></span></p>
          <p>no telp kedua <span>{{!empty($pelamar->no_hp2) ? $pelamar->no_hp2 : '-'}}</span></p>
          <p>account instagram
            <span>
              @if(!empty($pelamar->username_ig))
              <a href="https://www.instagram.com/{{$pelamar->username_ig}}" target="blank">instagram pelamar</a>
              @else
              -
              @endif
            </span>
          </p>
          <p>account twitter
            <span>
              @if(!empty($pelamar->username_tw))
              <a href="https://twitter.com/{{$pelamar->username_tw}}" target="blank">twitter pelamar</a>
              @else
              -
              @endif
            </span>
          </p>
          <p>username twitter <span>{{!empty($pelamar->username_tw) ? '@' . $pelamar->username_tw : '-'}}</span></p>
          <p>link youtube
            <span>
              @if(!empty($pelamar->link_youtube))
              <a href="{{$pelamar->link_youtube}}" target="blank">link youtube pelamar</a>
              @else
              -
              @endif
            </span>
          </p>
          <p>link facebook
            <span>
              @if(!empty($pelamar->link_facebook))
              <a href="{{$pelamar->link_facebook}}" target="blank">link facebook pelamar</a>
              @else
              -
              @endif
            </span>
          </p>
          <p>status menikah<span>{{$pelamar->status_menikah ? 'Sudah Menikah' : 'Belum Menikah'}}</span></p>
          <p>gaji terakhir<span>Rp{{!empty($pelamar->gaji_terakhir) ? number_format(preg_replace('/[^0-9]/', '', $pelamar->gaji_terakhir)) : '-'}}</span></p>
          <p>gaji yang diharapkan<span>Rp{{!empty($pelamar->gaji_ekspektasi) ? number_format(preg_replace('/[^0-9]/', '', $pelamar->gaji_ekspektasi)) : '-'}}</span></p>
          <h6>berkas <span>pelamar</span></h6>
          <p>foto pelamar <span><a href="{{route('pelamar.download.file', ['tipe' => 'foto', 'kodePelamar' => $pelamar->kode_pelamar])}}" target="blank">download foto pelamar</a></span></p>
          <p>ktp pelamar <span><a href="{{route('pelamar.download.file', ['tipe' => 'ktp', 'kodePelamar' => $pelamar->kode_pelamar])}}" target="blank">download ktp pelamar</a></span></p>
          <p>sim pelamar
            <span>
              @if(!empty($pelamar->sim))
              <a href="{{route('pelamar.download.file', ['tipe' => 'sim', 'kodePelamar' => $pelamar->kode_pelamar])}}" target="blank">download sim pelamar</a>
              @else
              -
              @endif
            </span>
          </p>
          <p>document pelamar
            <span>
              @if(!empty($pelamar->document_lain))
              <a href="{{route('pelamar.download.file', ['tipe' => 'document', 'kodePelamar' => $pelamar->kode_pelamar])}}" target="blank">download document pelamar</a>
              @else
              -
              @endif
            </span>
          </p>

          <h6>riwayat pendidikan <span>pelamar</span></h6>
          @foreach($pelamar->pendidikanPelamar as $loopItem)
          <p>tahun masuk dan lulus <span>{{$loopItem->tahun_awal}} - {{$loopItem->tahun_akhir}}</span></p>
          <p>nama jenjang <span>{{$loopItem->jenjang ?? '-'}}</span></p>
          <p>nama jurusan <span>{{$loopItem->jurusan ?? '-'}}</span></p>
          <p>nama institusi <span>{{$loopItem->institusi ?? '-'}}</span></p>
          <div class="tda__break__line mb-4"></div>
          @endforeach

          <h6>pengalaman pekerjaan <span>pelamar</span></h6>
          @foreach($pelamar->pengalamanKerja as $loopItem)
          <p>tahun masuk dan keluar <span>{{$loopItem->tahun_awal}} - {{$loopItem->tahun_akhir}}</span></p>
          <p>nama perusahaan <span>{{$loopItem->perusahaan ?? '-'}}</span></p>
          <p>nama posisi <span>{{$loopItem->posisi ?? '-'}}</span></p>
          <p>deskripsi pekerjaan <span>{{$loopItem->deskripsi ?? '-'}}</span></p>
          <div class="tda__break__line mb-4"></div>
          @endforeach

          <h6>pengalaman organisasi <span>pelamar</span></h6>
          @foreach($pelamar->pengalamanOrganisasi as $loopItem)
          <p>tahun masuk dan keluar <span>{{$loopItem->tahun_awal}} - {{$loopItem->tahun_akhir}}</span></p>
          <p>nama organisasi <span>{{$loopItem->organisasi ?? '-'}}</span></p>
          <p>nama posisi <span>{{$loopItem->posisi ?? '-'}}</span></p>
          <p>deskripsi organisasi <span>{{$loopItem->deskripsi ?? '-'}}</span></p>
          <div class="tda__break__line mb-4"></div>
          @endforeach
        </div>
        <!-- <div class="col-lg-3">
          <img src="{{asset('storage/' . $pelamar->foto_pelamar)}}" class="img-thumbnail tda__foto__pelamar" alt="{{$pelamar->kode_pelamar}}-img">
        </div> -->
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    $('.copy__button').tooltip({
      trigger: 'click',
      placement: 'bottom'
    });

    function setTooltip(message) {
      $('.copy__button').tooltip('hide')
        .attr('data-original-title', message)
        .tooltip('show');
    }

    function hideTooltip() {
      setTimeout(function() {
        $('.copy__button').tooltip('hide');
      }, 1000);
    }

    const clipboard = new ClipboardJS('.copy__button');

    clipboard.on('success', (e) => {
      setTooltip('Copied!');
      hideTooltip();
    });
  });
</script>
@endpush

@push('styles')
<style>
  .tda__break__line {
    width: 100%;
    height: .1rem;
    background: #f9f9f9;
  }

  span.badge-status {
    padding: 5px 12px;
    top: -5px;
  }

  span.badge-status.badge-info {
    cursor: pointer;
  }

  img.tda__foto__pelamar {
    width: 100%;
    height: 300px;
    object-fit: fill;
  }

  .tda__pelamar__info p {
    position: relative;
    font-weight: bold !important;
    line-height: .8rem;
    text-transform: capitalize;
  }

  .tda__pelamar__info p::after {
    content: ":";
    position: absolute;
    left: 10.5rem;
  }

  .tda__pelamar__info p span {
    position: absolute;
    font-weight: normal;
    text-transform: none;
    left: 11.5rem;
  }

  .tda__pelamar__info h6 {
    text-transform: capitalize;
    margin-top: 2.5rem;
    margin-bottom: 1.5rem;
  }

  .tda__pelamar__info h6:nth-child(1) {
    margin-top: 0;
  }
</style>
@endpush