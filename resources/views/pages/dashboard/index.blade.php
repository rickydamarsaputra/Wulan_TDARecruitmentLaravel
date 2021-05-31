@extends('layout.dashboard')
@section('title', 'Dashboard')

@section('content')
<section class="section">
  <div class="section-header text-capitalize d-flex justify-content-between">
    <h1>@yield('title')</h1>
    @if(auth()->user()->role == 'member')
    <a href="{{route('member.pelamar.export.excel', auth()->user()->member->kode_member)}}" class="btn btn-success mr-2" target="blank">export EXCEL Pelamar</a>
    @endif
  </div>

  <div class="section-body">
    @if(auth()->user()->role == 'member')
    <div class="row">
      <div class="col">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="far fa-newspaper"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Jumlah Lowongan Aktif</h4>
            </div>
            <div class="card-body">
              {{$countLowonganAktif}}
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card card-statistic-1">
          <div class="card-icon bg-info">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Jumlah Pelamar</h4>
            </div>
            <div class="card-body">
              {{$countPelamar}}
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
</section>
@endsection