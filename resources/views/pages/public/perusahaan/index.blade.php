@extends('layout.public')

@section('content')
<div class="col-lg-10">
  <div class="card card-primary">
    <div class="card-header">
      <h4 class="text-capitalize">lamaran pada perusahaan {{$titlePage}}</h4>
    </div>

    <div class="card-body">
      <form action="{{route('perusahaan.pelamar.process', $member->kode_member)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row mb-4 align-items-center">
          <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">posisi yang dilamar</label>
          <div class="col-lg">
            <select class="form-control" name="id_lowongan">
              @foreach($lowongan as $loopItem)
              <option value="{{$loopItem->ID_lowongan}}">{{$loopItem->label}}</option>
              @endforeach
            </select>
            <small class="form-text text-danger text-capitalize"></small>
          </div>
        </div>
        <div class="tda__break__line mb-4"></div>
        <div class="form-group row mb-4 align-items-center">
          <label class="tda__required__field col-form-label col-form-label text-nowrap text-capitalize col-sm-2">nama</label>
          <div class="col-lg">
            <input type="text" class="form-control" name="nama" placeholder="masukkan nama...">
            @error('nama')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
        </div>
        <!-- <div class="form-group row mb-4 align-items-center">
          <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">no telp</label>
          <div class="col-lg">
            <input type="text" class="form-control" name="no_telp" placeholder="masukkan no telp...">
          </div>
        </div> -->
        <div class="form-group row mb-4 align-items-center">
          <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">jenis kelamin</label>
          <div class="col-lg">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="jenis_kelamin" value="laki_laki" checked>
              <label class="form-check-label text-capitalize">
                laki laki
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="jenis_kelamin" value="perempuan">
              <label class="form-check-label text-capitalize">
                perempuan
              </label>
            </div>
          </div>
        </div>
        <div class="form-group row mb-4 align-items-center">
          <label class="tda__required__field col-form-label col-form-label text-nowrap text-capitalize col-sm-2">alamat</label>
          <div class="col-lg">
            <textarea class="form-control" name="alamat" placeholder="masukkan alamat..." style="height: 5rem;"></textarea>
            @error('alamat')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
        </div>
        <div class="form-group row mb-4 align-items-center">
          <label class="tda__required__field col-form-label col-form-label text-nowrap text-capitalize col-sm-2">upload ktp & sim</label>
          <div class="col-lg">
            <div class="row tda__file__upload__data">
              <div class="col-lg">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="pelamar__ktp" name="pelamar_ktp">
                  <label class="custom-file-label" for="pelamar__ktp">upload ktp...(ex : ktp.jpg/png)</label>
                </div>
                @error('pelamar_ktp')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
              </div>
              <div class="col-lg">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="pelamar__sim" name="pelamar_sim">
                  <label class="custom-file-label" for="pelamar__sim">upload sim (optional)...(ex : sim.jpg/png)</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group row mb-4 align-items-center">
          <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">document lain</label>
          <div class="col-lg">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="document__lain" name="document_lain">
              <label class="custom-file-label" for="document__lain">upload document lain (optional)... (utamakan file pdf, bila diperlukan, ex : file.pdf)</label>
            </div>
            @error('document_lain')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
        </div>
        <div class="form-group row mb-4 align-items-center">
          <label class="tda__required__field col-form-label col-form-label text-nowrap text-capitalize col-sm-2">foto</label>
          <div class="col-lg">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="foto_pelamar" name="foto_pelamar">
              <label class="custom-file-label" for="foto_pelamar">upload foto...(ex : foto.jpg/png)</label>
            </div>
            @error('foto_pelamar')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
        </div>
        <div class="form-group row mb-4 align-items-center">
          <label class="tda__required__field col-form-label col-form-label text-nowrap text-capitalize col-sm-2">email</label>
          <div class="col-lg">
            <input type="text" class="form-control" name="email" placeholder="masukkan email...">
            @error('email')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
        </div>
        <div class="form-group row mb-4 align-items-center">
          <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">alamat blog</label>
          <div class="col-lg">
            <input type="text" class="form-control" name="web_blog" placeholder="masukkan alamat blog...">
          </div>
        </div>
        <div class="form-group row mb-4 align-items-center">
          <label class="tda__required__field col-form-label col-form-label text-nowrap text-capitalize col-sm-2">no telp</label>
          <div class="col-lg">
            <div class="row tda__no__telp__data">
              <div class="col-lg">
                <input type="text" class="form-control" name="no_telp_1" placeholder="masukkan no telp pertama...">
                @error('no_telp_1')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
              </div>
              <div class="col-lg">
                <input type="text" class="form-control" name="no_telp_2" placeholder="masukkan no telp kedua (optional)...">
              </div>
            </div>
          </div>
        </div>
        <div class="form-group row mb-4 align-items-center">
          <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">username instagram</label>
          <div class="col-lg">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">@</span>
              </div>
              <input type="text" class="form-control" name="username_ig" placeholder="masukkan username instagram...">
            </div>
          </div>
        </div>
        <div class="form-group row mb-4 align-items-center">
          <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">link facebook</label>
          <div class="col-lg">
            <input type="text" class="form-control" name="link_facebook" placeholder="masukkan link facebook...">
          </div>
        </div>
        <div class="form-group row mb-4 align-items-center">
          <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">username twitter</label>
          <div class="col-lg">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">@</span>
              </div>
              <input type="text" class="form-control" name="username_tw" placeholder="masukkan username twitter...">
            </div>
          </div>
        </div>
        <div class="form-group row mb-4 align-items-center">
          <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">channel youtube</label>
          <div class="col-lg">
            <input type="text" class="form-control" name="link_youtube" placeholder="masukkan link channel youtube...">
          </div>
        </div>
        <div id="tda__pendidikan__pelamar">
          <div class="form-group row mb-4 align-items-center">
            <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">pendidikan</label>
            <div class="col-lg">
              <div class="row align-items-center">
                <div class="col">
                  <input type="text" class="form-control" name="tahun_awal_pendidikan[]" placeholder="tahun awal...">
                </div>
                <div> - </div>
                <div class="col">
                  <input type="text" class="form-control" name="tahun_akhir_pendidikan[]" placeholder="tahun akhir...">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <input type="text" class="form-control" name="nama_institusi_pendidikan[]" placeholder="masukkan nama institusi...">
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <input type="text" class="form-control" name="nama_jurusan_pendidikan[]" placeholder="masukkan nama jurusan...">
            </div>
          </div>
          <div class="tda__flex__button__group">
            <button type="button" id="tda__tambah__pendidikan" class="btn btn-success text-capitalize">tambah pendidikan</button>
          </div>
          <div class="tda__break__line mb-4"></div>
        </div>
        <div id="tda__pengalaman__kerja__pelamar">
          <div class="form-group row mb-4 align-items-center">
            <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">pengalaman kerja</label>
            <div class="col-lg">
              <div class="row align-items-center">
                <div class="col">
                  <input type="text" class="form-control" name="tahun_awal_pengalaman_kerja[]" placeholder="tahun awal...">
                </div>
                <div> - </div>
                <div class="col">
                  <input type="text" class="form-control" name="tahun_akhir_pengalaman_kerja[]" placeholder="tahun akhir...">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <input type="text" class="form-control" name="nama_perusahaan[]" placeholder="masukkan nama perusahaan...">
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <input type="text" class="form-control" name="nama_posisi[]" placeholder="masukkan nama posisi...">
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <textarea class="form-control" name="deskripsi_tanggung_jawab[]d" placeholder="masukkan deskripsi tanggung jawab..." style="height: 5rem;"></textarea>
            </div>
          </div>
          <div class="tda__flex__button__group">
            <button type="button" id="tda__tambah__pengalaman__kerja" class="btn btn-info text-capitalize mr-2">tambah pengalaman kerja</button>
          </div>
          <div class="tda__break__line mb-4"></div>
        </div>
        <div id="tda__pengalaman__organisasi__pelamar">
          <div class="form-group row mb-4 align-items-center">
            <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">pengalaman organisasi</label>
            <div class="col-lg">
              <div class="row align-items-center">
                <div class="col">
                  <input type="text" class="form-control" name="tahun_awal_pengalaman_organisasi[]" placeholder="tahun awal...">
                </div>
                <div> - </div>
                <div class="col">
                  <input type="text" class="form-control" name="tahun_akhir_pengalaman_organisasi[]" placeholder="tahun akhir...">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <input type="text" class="form-control" name="nama_organisasi[]" placeholder="masukkan nama organisasi...">
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <input type="text" class="form-control" name="nama_posisi_organisasi[]" placeholder="masukkan nama posisi di organisasi...">
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <textarea class="form-control" name="deskripsi_pengalaman_organisasi[]" placeholder="masukkan deskripsi pengalaman organisasi..." style="height: 5rem;"></textarea>
            </div>
          </div>
          <div class="tda__flex__button__group">
            <button type="button" id="tda__tambah__pengalaman__organisasi" class="btn btn-warning text-capitalize">tambah pengalaman organisasi</button>
          </div>
          <div class="tda__break__line mb-4"></div>
        </div>

        <button type="submit" class="btn btn-primary text-capitalize">submit</button>
      </form>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    let counterPendidikan = 2;
    let counterPengalamanKerja = 2;
    let counterPengalamanOrganisasi = 2;

    $('#tda__tambah__pendidikan').on('click', (e) => {
      const element = `
      <div id="pendidikan__pelamar__${counterPendidikan}">
        <div class="form-group row mb-4 justify-content-end align-items-center">
          <div class="col-sm-2">
            <buttom type="button" data-pendidikan-id="pendidikan__pelamar__${counterPendidikan}" class="btn btn-sm btn-danger mb-3 text-capitalize tda__delete__pendidikan__pelamar">delete</button>
          </div>
          <div class="col-lg">
            <div class="row align-items-center">
              <div class="col">
                <input type="text" class="form-control" name="tahun_awal_pendidikan[]" placeholder="tahun awal...">
              </div>
              <div> - </div>
              <div class="col">
                <input type="text" class="form-control" name="tahun_akhir_pendidikan[]" placeholder="tahun akhir...">
              </div>
            </div>
          </div>
        </div>
        <div class="form-group row mb-4 justify-content-end align-items-center">
          <div class="col-lg-10">
            <input type="text" class="form-control" name="nama_institusi_pendidikan[]" placeholder="masukkan nama institusi...">
          </div>
        </div>
        <div class="form-group row mb-4 justify-content-end align-items-center">
          <div class="col-lg-10">
            <input type="text" class="form-control" name="nama_jurusan_pendidikan[]" placeholder="masukkan nama jurusan...">
          </div>
        </div>
        <div class="tda__break__line mb-4"></div>
      </div>
      `;

      $('#tda__pendidikan__pelamar').append(element);
      counterPendidikan++;
    });

    $('#tda__tambah__pengalaman__kerja').on('click', (e) => {
      const element = `
      <div id="pengalaman__kerja__pelamar__${counterPengalamanKerja}">
        <div class="form-group row mb-4 align-items-center">
            <div class="col-lg-2">
              <buttom type="button" data-pengalaman-kerja-id="pengalaman__kerja__pelamar__${counterPengalamanKerja}" class="btn btn-sm btn-danger mb-3 text-capitalize tda__delete__pengalaman__kerja__pelamar">delete</button>
            </div>
            <div class="col-lg">
              <div class="row align-items-center">
                <div class="col">
                  <input type="text" class="form-control" name="tahun_awal_pengalaman_kerja[]" placeholder="tahun awal...">
                </div>
                <div> - </div>
                <div class="col">
                  <input type="text" class="form-control" name="tahun_akhir_pengalaman_kerja[]" placeholder="tahun akhir...">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <input type="text" class="form-control" name="nama_perusahaan[]" placeholder="masukkan nama perusahaan...">
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <input type="text" class="form-control" name="nama_posisi[]" placeholder="masukkan nama posisi...">
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <textarea class="form-control" name="deskripsi_tanggung_jawab[]d" placeholder="masukkan deskripsi tanggung jawab..." style="height: 5rem;"></textarea>
            </div>
          </div>
          <div class="tda__break__line mb-4"></div>
      </div>
      `;

      $('#tda__pengalaman__kerja__pelamar').append(element);
    });

    $('#tda__tambah__pengalaman__organisasi').on('click', (e) => {
      const element = `
        <div id="pengalaman__organisasi__pelamar__${counterPengalamanOrganisasi}">
        <div class="form-group row mb-4 align-items-center">
            <div class="col-lg-2">
              <buttom type="button" data-pengalaman-organisasi-id="pengalaman__organisasi__pelamar__${counterPengalamanOrganisasi}" class="btn btn-sm btn-danger mb-3 text-capitalize tda__delete__pengalaman__organisasi__pelamar">delete</button>
            </div>
            <div class="col-lg">
              <div class="row align-items-center">
                <div class="col">
                  <input type="text" class="form-control" name="tahun_awal_pengalaman_organisasi[]" placeholder="tahun awal...">
                </div>
                <div> - </div>
                <div class="col">
                  <input type="text" class="form-control" name="tahun_akhir_pengalaman_organisasi[]" placeholder="tahun akhir...">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <input type="text" class="form-control" name="nama_organisasi[]" placeholder="masukkan nama organisasi...">
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <input type="text" class="form-control" name="nama_posisi_organisasi[]" placeholder="masukkan nama posisi di organisasi...">
            </div>
          </div>
          <div class="form-group row mb-4 justify-content-end align-items-center">
            <div class="col-lg-10">
              <textarea class="form-control" name="deskripsi_pengalaman_organisasi[]" placeholder="masukkan deskripsi pengalaman organisasi..." style="height: 5rem;"></textarea>
            </div>
          </div>
          <div class="tda__break__line mb-4"></div>
        </div>
      `;

      $('#tda__pengalaman__organisasi__pelamar').append(element);
      counterPengalamanOrganisasi++;
    });

    $('.tda__delete__pendidikan__pelamar').ready((event) => {
      $(event).on('click', (e) => {
        const buttonClass = e.target.getAttribute('class');

        try {
          if (buttonClass.includes('tda__delete__pendidikan__pelamar')) {
            const elementId = e.target.getAttribute('data-pendidikan-id');
            $(`#${elementId}`).remove();
          }
        } catch (error) {

        }
      });
    });

    $('.tda__delete__pengalaman__kerja__pelamar').ready((event) => {
      $(event).on('click', (e) => {
        const buttonClass = e.target.getAttribute('class');

        try {
          if (buttonClass.includes('tda__delete__pengalaman__kerja__pelamar')) {
            const elementId = e.target.getAttribute('data-pengalaman-kerja-id');
            $(`#${elementId}`).remove();
          }
        } catch (error) {

        }
      });
    });

    $('.tda__delete__pengalaman__organisasi__pelamar').ready((event) => {
      $(event).on('click', (e) => {
        const buttonClass = e.target.getAttribute('class');

        try {
          if (buttonClass.includes('tda__delete__pengalaman__organisasi__pelamar')) {
            const elementId = e.target.getAttribute('data-pengalaman-organisasi-id');
            $(`#${elementId}`).remove();
          }
        } catch (error) {

        }
      });
    });

  });
</script>
@endpush

@push('styles')
<style>
  .tda__flex__button__group {
    display: flex;
    justify-content: flex-end;
  }

  .tda__flex__button__group button {
    margin-bottom: 1rem;
  }

  @media (max-width: 575.98px) {
    .tda__flex__button__group {
      display: block;
    }

    .tda__flex__button__group button {
      display: block;
      width: 100%;
      margin-bottom: 1rem;
    }

    .tda__flex__button__group button.btn-primary {
      margin-bottom: 2rem;
    }

    #tda__pendidikan__pelamar .btn-danger,
    #tda__pengalaman__kerja__pelamar .btn-danger,
    #tda__pengalaman__organisasi__pelamar .btn-danger {
      display: block;
      width: 100%;
    }

    .tda__file__upload__data .col-lg:nth-child(1),
    .tda__no__telp__data .col-lg:nth-child(1) {
      margin-bottom: 1.5rem;
    }
  }

  label.tda__required__field::after {
    content: "*";
    position: absolute;
    margin-left: 3px;
    margin-top: -5px;
    color: red;
    font-size: 18px;
  }
</style>
@endpush