@extends('layout.public')

@section('content')
<div class="col-lg-10 align-items-center">
  <div class="card card-primary">
    <div class="card-header">
      <h4 class="text-capitalize">lamaran pada perusahaan {{$pelamar->member->nama_bisnis}}</h4>
    </div>
    <div class="card-body">
      {!! $message !!}
    </div>
  </div>
</div>
@endsection