@extends('layout.dashboard')
@section('title', 'Member Detail')

@section('content')
<section class="section">
  <div class="section-header text-capitalize d-flex justify-content-between">
    <h1>Member Detail</h1>
    <div>
      <a href="{{route('member.pelamar.export.excel', $member->kode_member)}}" class="btn btn-success mr-2" target="blank">export EXCEL Pelamar</a>
      <a href="{{route('member.index')}}" class="btn btn-primary">kembali</a>
    </div>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <div class="tda__info__member">
          <h6>nama <span>{{$member->nama_member}}</span></h6>
          <h6>email <span>{{$member->user->email}}</span></h6>
          <h6>username <span>{{$member->user->username}}</span></h6>
          <h6>kode member <span>{{$member->kode_member}}</span></h6>
          <h6>nomor member <span>{{$member->nomor_member}}</span></h6>
          <h6>nama bisnis <span>{{$member->nama_bisnis}}</span></h6>
          <h6>tanggal bergabung <span>{{$member->created_at}}</span></h6>
        </div>
        <div class="d-flex justify-content-end">
          <form action="{{route('member.change.status', [$member->ID_member, !$member->status_aktivasi ? 'terima' : 'tolak'])}}" method="POST">
            @csrf
            @method('put')
            <button class="btn btn-{{!$member->status_aktivasi ? 'success' : 'danger'}} text-uppercase">{{!$member->status_aktivasi ? 'aktifkan' : 'non aktifkan'}}</button>
          </form>
        </div>
        <!-- @if(!$member->status_aktivasi) -->
        <!-- <div class="tda__break__line"></div> -->
        <!-- <div class="d-flex mt-4">
          <form action="{{route('member.change.status', [$member, 'tolak'])}}" method="POST">
            @csrf
            @method('put')
            <button class="btn btn-danger text-uppercase">tolak member</button>
          </form>
          <form action="{{route('member.change.status', [$member, 'terima'])}}" method="POST">
            @csrf
            @method('put')
            <button class="btn btn-success text-uppercase ml-2">terima member</button>
          </form>
        </div> -->
        <!-- @endif -->
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <form action="{{route('member.update', $member->nama_member)}}" method="POST">
          @csrf
          @method('put')
          <div class="form-group">
            <label for="text">Nama</label>
            <input name="nama_member" id="nama_member" type="text" class="form-control" value="{{$member->nama_member}}" placeholder="masukkan...">
            @error('nama_member')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          <div class="form-group">
            <label for="text">Nomor Member</label>
            <input name="nomor_member" id="nomor_member" type="text" class="form-control" value="{{$member->nomor_member}}" placeholder="masukkan nomor...">
            @error('nomor_member')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          <div class="form-group">
            <label for="text">Nama Bisnis</label>
            <input name="nama_bisnis" id="nama_bisnis" type="text" class="form-control" value="{{$member->nama_bisnis}}" placeholder="masukkan nama bisnis...">
            @error('nama_bisnis')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          <div class="form-group">
            <label for="text">Kode Member</label>
            <input name="kode_member" id="kode_member" type="text" class="form-control" value="{{$member->kode_member}}" readonly>
            @error('kode_member')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          <button type="submit" class="btn btn-success">Update</button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    const namaBisnis = document.querySelector("#nama_bisnis");
    const kodeMember = document.querySelector("#kode_member");

    namaBisnis.addEventListener("keyup", (e) => {
      let requestURL = "{{route('helpers.generate.slug', ':slug')}}";
      requestURL = requestURL.replace(":slug", e.target.value);

      fetch(requestURL)
        .then((res) => res.json())
        .then((data) => {
          console.log(data);
          kodeMember.value = data.slug;
        })
        .catch((err) => console.error(err));
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

  .tda__info__member h6 {
    text-transform: capitalize;
    position: relative;
  }

  .tda__info__member h6::after {
    content: ":";
    position: absolute;
    left: 10rem;
  }

  .tda__info__member h6 span {
    position: absolute;
    left: 12rem;
    font-weight: normal;
  }
</style>
@endpush