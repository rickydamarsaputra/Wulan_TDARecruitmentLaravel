@extends('layout.dashboard')
@section('title', 'lowongan page')

@section('content')
<section class="section">
  <div class="section-header text-capitalize">
    <h1>@yield('title')</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="data__table__lowongan">
            <thead>
              <tr class="text-uppercase">
                <th class="text-center">#</th>
                <th class="text-center">nama lowongan</th>
                @if(auth()->user()->role == 'admin')
                <th class="text-center">nama member</th>
                @endif
                <th class="text-center">tanggal publish</th>
                <th class="text-center">status</th>
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
    Array.prototype.insert = function(index, item) {
      this.splice(index, 0, item);
    };

    const userRole = "{{auth()->user()->role}}";
    const columnsTableLowongan = [{
        data: "DT_RowIndex",
        orderable: false,
        searchable: false
      },
      {
        data: "lowongan",
        render: (data) => {
          data = JSON.parse(data);
          let routeURL = "{{route('lowongan.detail', ':idLowongan')}}";
          routeURL = routeURL.replace(":idLowongan", data.ID_lowongan);
          return `<a href="${routeURL}">${data.label}</a>`;
        }
      },
      {
        data: "created_at",
        render: (data) => {
          return moment(data).format("D MMMM YYYY");
        }
      },
      {
        data: "status_aktif",
        render: (data) => {
          const message = data ? "aktif" : "tidak aktif";
          const buttonColor = data ? "success" : "danger";
          return `<button class='btn btn-${buttonColor} btn-sm btn-block text-uppercase'>${message}</button>`;
        }
      },
    ];

    if (userRole == 'admin') {
      columnsTableLowongan.insert(2, {
        data: "member.nama_member",
        render: (data) => {
          let routeURL = "{{route('member.detail', ':namaMember')}}";
          routeURL = routeURL.replace(":namaMember", data);
          return `<a href="${routeURL}">${data}</a>`;
        }
      });
    }

    $("#data__table__lowongan").DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: "{{route('datatables.lowongan')}}",
      columns: columnsTableLowongan,
    });
  });
</script>
@endpush

@push('styles')
<style>
  table#data__table__lowongan {
    width: -webkit-fill-available !important;
  }
</style>
@endpush