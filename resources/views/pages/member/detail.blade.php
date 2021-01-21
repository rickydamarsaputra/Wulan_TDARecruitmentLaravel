@extends('layout.dashboard')
@section('title', 'detail page ' . $member->nama_member)

@section('content')
<section class="section">
  <div class="section-header text-capitalize d-flex justify-content-between">
    <h1>@yield('title')</h1>
    <a href="{{route('member.index')}}" class="btn btn-primary">kembali</a>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <div class="tda__info__member">
          <h6>nama <span>{{$member->nama_member}}</span></h6>
          <h6>kode member <span>{{$member->kode_member}}</span></h6>
          <h6>nomor member <span>{{$member->nomor_member}}</span></h6>
          <h6>nama bisnis <span>{{$member->nama_bisnis}}</span></h6>
          <h6>tanggal bergabung <span>{{$member->created_at}}</span></h6>
        </div>
        @if(!$member->status_aktivasi)
        <div class="tda__break__line"></div>
        <div class="d-flex">
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
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection

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