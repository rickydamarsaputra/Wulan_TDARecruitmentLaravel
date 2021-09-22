@extends('layout.public')

@section('content')
<div class="col-lg-10">
  <div class="card card-primary">
    <div class="card-header d-flex justify-content-center">
      <h4>{{$titlePage}}</h4>
    </div>
    <div class="card-body">
      <div class="d-flex justify-content-center">
        <a href="{{route('perusahaan.pelamar.test.iq.question.view', ['idPelamar' => $idPelamar, 'kodePelamar' => $kodePelamar, 'questionNumber' => 1])}}" class="btn btn-primary text-capitalize">mulai test IQ</a>
      </div>
    </div>
  </div>
</div>
@endsection