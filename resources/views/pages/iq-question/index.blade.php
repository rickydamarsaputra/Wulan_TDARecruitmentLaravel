@extends('layout.dashboard')
@section('title', 'Iq Test Soal')

@section('content')
<section class="section">
  <div class="section-header text-capitalize d-flex justify-content-between">
    <h1>Daftar Soal Iq Test</h1>
    <a href="{{route('iq-question.create.view')}}" class="btn btn-primary">create soal</a>
  </div>
  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="data__table__test__iq">
            <thead>
              <tr class="text-uppercase">
                <th class="text-center">#</th>
                <th>deskripsi</th>
                <th>point benar</th>
                <th>jawaban benar</th>
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
    $("#data__table__test__iq").DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: "{{route('datatables.test.iq')}}",
      columns: [
        {
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'desc_soal',
          render: (data) =>{
            return `<pre>${data.slice(0, 150)}...</pre>`
          }
        },
        {
          data: 'poin_benar',
        },
        {
          data: 'jawaban_benar',
        },
      ]
    });
  });
</script>
@endpush

@push('styles')
<style>
  table#data__table__member {
    width: -webkit-fill-available !important;
  }
</style>
@endpush