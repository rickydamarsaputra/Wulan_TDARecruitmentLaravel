@extends('layout.dashboard')
@section('title', 'Member')

@section('content')
<section class="section">
  <div class="section-header text-capitalize d-flex justify-content-between">
    <h1>Daftar Member</h1>
    <div>
      <a href="{{route('member.export.pdf')}}" class="btn btn-danger" target="blank">export PDF</a>
      <a href="{{route('member.register.view')}}" class="btn btn-primary mx-2" target="blank">create member</a>
      <a href="{{route('member.export.excel')}}" class="btn btn-success" target="blank">export EXCEL</a>
    </div>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="data__table__member">
            <thead>
              <tr class="text-uppercase">
                <th class="text-center">#</th>
                <th>nama member</th>
                <th>nomor member</th>
                <th>nama bisnis</th>
                <th>kode member</th>
                <th>status</th>
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
    $("#data__table__member").DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: "{{route('datatables.member')}}",
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: "nama_and_kode",
          render: (data) => {
            let routeURL = "{{route('member.detail', ':kodeMember')}}";
            routeURL = routeURL.replace(":kodeMember", data[1]);

            return `<a href="${routeURL}">${data[0]}</a>`;
          }
        },
        {
          data: "nomor_member",
        },
        {
          data: "nama_bisnis"
        },
        {
          data: "kode_member"
        },
        {
          data: "status_aktivasi",
          render: (data) => {
            const message = (data == 0) ? "belum diproses" : (data == 1) ? "aktif" : "ditolak";
            const buttonColor = (data == 0) ? "info" : (data == 1) ? "success" : "danger";
            return `<button class='btn btn-${buttonColor} btn-sm btn-block text-uppercase'>${message}</button>`;
          }
        },
      ],
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