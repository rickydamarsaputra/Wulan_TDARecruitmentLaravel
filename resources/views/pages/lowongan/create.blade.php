@extends('layout.dashboard')
@section('title', 'Tambah Lowongan')

@section('content')
<section class="section">
  <div class="section-header text-capitalize d-flex justify-content-between">
    <h1>tambah lowongan</h1>
    <a href="" class="btn btn-primary">kembali</a>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <form action="{{route('lowongan.create.process')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="text">Nama Lowongan</label>
            <input name="nama_lowongan" id="nama_lowongan" type="text" class="form-control" value="{{old('nama_lowongan')}}" placeholder="masukkan nama lowongan...">
            @error('nama_lowongan')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          @if(auth()->user()->role == 'admin')
          <div class="form-group">
            <label for="text">Member</label>
            <select class="form-control" name="member">
              <option value="">Pilih Member</option>
              @foreach($member as $loopItem)
              <option value="{{$loopItem->ID_member}}">{{$loopItem->nama_member}}</option>
              @endforeach
            </select>
            @error('member')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          @endif
          <div class="form-group">
            <label for="text">Custom Message</label>
            <textarea class="form-control" name="custom_message" placeholder="masukkan custom message (optional)..." style="height: 10rem;"></textarea>
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
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
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