@extends('layout.public')

@section('content')
<div class="col-lg-10">
  <div class="card card-primary">
    <div class="card-header">
      <h4>{{$titlePage}}</h4>
    </div>
    <div class="card-body">
      <p><span class="text-uppercase font-weight-bold">instruksi : </span> Setiap nomor dibawah ini memuat 4 (empat) kalimat. Tugas anda adalah :</p>
      <p>
        1. Pilih bulatan pada kolom dibawah huruf <span class="font-weight-bold">[M]</span> di samping kalimat yang <span class="font-weight-bold">PALING menggambarkan</span> diri anda
        <br />
        2. Pilih bulatan pada kolom dibawah huruf <span class="font-weight-bold">[L]</span> di samping kalimat yang <span class="font-weight-bold">PALING TIDAK menggambarkan</span> diri anda
      </p>
      <form action="{{route('perusahaan.pelamar.test.disc.process', [$pelamar->ID_pelamar, $pelamar->kode_pelamar])}}" method="POST">
        @csrf
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col" class="text-center bg-secondary">No.</th>
              <th scope="col" class="text-center bg-warning">M</th>
              <th scope="col" class="text-center bg-success">L</th>
              <th scope="col" class="bg-danger text-white">Gambaran Diri</th>
            </tr>
          </thead>
          <tbody>
            @php
            $i = 1;
            @endphp
            @foreach($gambaran as $loopItem)
            @if($i == 4)
            <tr style="border-bottom: 0.2rem solid black;">
              @else
            <tr>
              @endif
              @if($i == 1)
              <th scope="row" rowspan="4" class="text-center bg-secondary">{{$loopItem->no_soal}}</th>
              <input type="hidden" name="nomor_soal[]" value="{{$loopItem->no_soal}}">
              @endif
              <td class="bg-warning">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="gambaran_no_{{$loopItem->no_soal}}[]_m" value="{{$loopItem->kunci_m}}" required>
                </div>
              </td>
              <td class="bg-success">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="gambaran_no_{{$loopItem->no_soal}}[]_l" value="{{$loopItem->kunci_l}}" required>
                </div>
              </td>
              <td>{{$loopItem->deskripsi}}</td>
              @php
              $i++;
              if($i > 4){
              $i = 1;
              }
              @endphp
            </tr>
            @endforeach
          </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    const gambaran = document.querySelectorAll('.form-check-input');

    console.log(gambaran);
  });
</script>
@endpush

@push('styles')
<style>
  .form-check {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .form-check-input {
    width: 1.5rem;
    height: 1.2rem;
  }
</style>
@endpush