@extends('layout.dashboard')
@section('title', 'detail lowongan ' . $lowongan->label)

@section('content')
<section class="section" x-data="{ isDetail: true }">
  <div class="section-header text-capitalize d-flex justify-content-between">
    <h1>@yield('title')</h1>
    <div>
      <a href="{{route('lowongan.index')}}" class="btn btn-primary mr-2">kembali</a>
      <button @click="isDetail = !isDetail" x-text="isDetail ? 'update' : 'detail'" :class="{'btn-success': isDetail === true, 'btn-info': isDetail === false}" type="button" class="btn text-capitalize"></button>
    </div>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body" x-show="isDetail === true">
        <div class="tda__info__lowongan">
          <h6>nama lowongan <span>{{$lowongan->label}}</span></h6>
          <h6>nama member <span>{{$lowongan->member->nama_member}}</span></h6>
          <h6 class="d-flex align-items-center">status
            <span>
              @if($lowongan->status_aktif)
              <button class="btn btn-success btn-sm btn-block text-uppercase">aktif</button>
              @else
              <button class="btn btn-danger btn-sm btn-block text-uppercase">tidak aktif</button>
              @endif
            </span>
          </h6>
          <h6>tanggal publish <span>{{date_format($lowongan->created_at, 'd M Y')}}</span></h6>
        </div>
        <div class="d-flex justify-content-end">
          <form action="{{route('lowongan.change.status', [$lowongan->ID_lowongan, !$lowongan->status_aktif ? 'terima' : 'tolak'])}}" method="POST">
            @csrf
            @method('put')
            <button class="btn btn-{{!$lowongan->status_aktif ? 'success' : 'danger'}} text-uppercase">{{!$lowongan->status_aktif ? 'aktifkan' : 'non aktifkan'}}</button>
          </form>
        </div>
      </div>
      <div class="card-body" x-show="isDetail === false">
        <form action="{{route('lowongan.update', $lowongan->ID_lowongan)}}" method="POST">
          @csrf
          @method('put')
          <div class="form-group">
            <label for="text">Nama Lowongan</label>
            <input name="nama_lowongan" id="nama_lowongan" type="text" class="form-control" value="{{$lowongan->label}}" placeholder="masukkan nama lowongan...">
            @error('nama_lowongan')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          <div class="form-group">
            <label for="text">Custom Message</label>
            <textarea class="form-control" name="custom_message" placeholder="masukkan custom message (optional)..." style="height: 10rem;">{{$lowongan->custom_message}}</textarea>
          </div>
          <div class="tda__note__lowongan__create">
            <h6>note</h6>
            <p>
              custom message ini bersifat <span class="font-weight-bold">opsional</span>, yang nanti akan di tampilkan setelah pelamar mengisi form lowongan.
              <br>jika dikosongkan maka akan berisi pesan default.
            </p>
            <p>
              gunakan <span class="font-weight-bold">[namaPelamar]</span> untuk mengisi nama pelamar
              <br>gunakan <span class="font-weight-bold">[namaPerusahaan]</span> untuk mengisi nama perusahaan / nama bisnis anda
            </p>
            <p>
              bila terdapat <span class="font-weight-bold"><code>{{"<br>"}}</code></span> biarkan saja karna itu untuk <span class="font-weight-bold">new line atau baris baru</span>
            </p>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h5 class="card-title text-capitalize">daftar pelamar di {{$lowongan->label}}</h5>
        <div class="table-responsive">
          <table class="table table-striped" id="data__table__pelamar__dilowongan__ini">
            <thead>
              <tr class="text-uppercase">
                <th class="text-center">#</th>
                <th class="text-center">nama pelamar</th>
                <th class="text-center">email</th>
                <th class="text-center">notelp</th>
                <th class="text-center">tgl submit</th>
                <th class="text-center">status</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    $("#data__table__pelamar__dilowongan__ini").DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: "{{route('datatables.pelamar.lowongan', $lowongan->ID_lowongan)}}",
      columns: [{
          data: "DT_RowIndex",
          orderable: false,
          searchable: false
        },
        {
          data: "pelamar",
          render: (data) => {
            data = JSON.parse(data);
            let requestUrl = "{{route('pelamar.detail', [':kodePelamar'])}}";
            requestUrl = requestUrl.replace(':kodePelamar', data.kode_pelamar);

            return `<a href="${requestUrl}">${data.nama_pelamar}</a>`;
          }
        },
        {
          data: "email"
        },
        {
          data: "no_hp1"
        },
        {
          data: "created_at",
          render: (data) => {
            return moment(data).format("D MMMM YYYY");
          }
        },
        {
          data: "pelamar",
          render: (data) => {
            data = JSON.parse(data);
            const message = !data.status ? "belum" : data.status == 1 ? "sedang" : "selesai";
            const buttonColor = !data.status ? "danger" : data.status == 1 ? "warning" : "success";
            const typeButton = data.status != 2 ? "submit" : "button";
            let actionURL = "{{route('pelamar.change.status', [':idPelamar'])}}";
            actionURL = actionURL.replace(":idPelamar", data.ID_pelamar);
            return `
              <form action="${actionURL}" method="POST">
                @csrf
                @method('put')
                <button type="${typeButton}" class='btn btn-${buttonColor} btn-sm btn-block text-uppercase'>${message} diproses</button>
              </form>
            `;
          }
        },
      ]
    });
  });
</script>
@endpush

@push('styles')
<style>
  .tda__break__line {
    width: 100%;
    height: .1rem;
    background: #D1D5DB;
    margin: 2rem 0;
  }

  table#data__table__pelamar__dilowongan__ini {
    width: -webkit-fill-available !important;
  }

  .tda__info__lowongan h6 {
    text-transform: capitalize;
    position: relative;
    margin-bottom: 1rem;
  }

  .tda__info__lowongan h6::after {
    content: ":";
    position: absolute;
    left: 10rem;
  }

  .tda__info__lowongan h6 span {
    position: absolute;
    left: 12rem;
    font-weight: normal;
  }

  .tda__note__lowongan__create h6,
  .tda__note__lowongan__create p {
    text-transform: capitalize;
    line-height: 1.3rem;
  }

  .tda__note__lowongan__create p span {
    text-transform: none;
  }
</style>
@endpush