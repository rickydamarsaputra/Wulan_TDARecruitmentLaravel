@extends('layout.dashboard')
@section('title', 'lowongan create page')

@section('content')
<section class="section">
  <div class="section-header text-capitalize d-flex justify-content-between">
    <h1>@yield('title')</h1>
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
          <div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection