@extends('layout.dashboard')
@section('title', 'Pelamar')

@section('content')
<section class="section">
  <div class="section-header text-capitalize d-flex justify-content-between">
    <h1>Daftar Pelamar</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <form class="tda-form-filter-pelamar">
          @csrf
          <div class="form-group row mb-4 align-items-center">
            <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">Hasil Test DISC</label>
            <div class="col-lg">
              <select class="form-control" name="interpretasi">
                <option value="">Semua</option>
                @foreach($interpretasi as $loopItem)
                <option value="{{$loopItem->ID_interpretasi}}">{{str_replace("Profile: ", "", $loopItem->judul)}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row mb-4 align-items-center">
            <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">jenjang pendidikan</label>
            <div class="col-lg">
              <select class="form-control" name="jenjang">
                <option value="">Semua</option>
                @foreach($jenjang as $loopItem)
                <option value="{{$loopItem}}">{{$loopItem}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row mb-4 align-items-center">
            <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">Status Menikah</label>
            <div class="col-lg">
              <div class="form-check">
                <input class="form-check-input" type="radio" id="status_menikah_sudah" name="status_menikah" value="1">
                <label class="form-check-label text-capitalize" for="status_menikah_sudah">
                  Sudah Menikah
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" id="status_menikah_belum" name="status_menikah" value="0">
                <label class="form-check-label text-capitalize" for="status_menikah_belum">
                  Belum Menikah
                </label>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4 align-items-center">
            <label class="col-form-label col-form-label text-nowrap text-capitalize col-sm-2">jenis kelamin</label>
            <div class="col-lg">
              <div class="form-check">
                <input class="form-check-input" type="radio" id="jenis_kelamin_laki_laki" name="jenis_kelamin" value="laki_laki">
                <label class="form-check-label text-capitalize" for="jenis_kelamin_laki_laki">
                  laki laki
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" id="jenis_kelamin_perempuan" name="jenis_kelamin" value="perempuan">
                <label class="form-check-label text-capitalize" for="jenis_kelamin_perempuan">
                  perempuan
                </label>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Filter</button>
          <button type="button" class="btn btn-success tda-export-excel">Export Excel</button>
          <button type="button" class="btn btn-danger tda-export-pdf">Export PDF</button>
        </form>
      </div>
    </div>
    <div class="card card-table-pelamar">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="data-table-pelamar">
            <thead>
              <tr class="text-uppercase">
                <th class="text-center">#</th>
                <th>nama</th>
                <th>lowongan</th>
                <!-- <th>jenjang pendidikan</th> -->
                <th>jenis kelamin</th>
                <th>status menikah</th>
                <th>test DISC</th>
                <th>jenjang</th>
                <!-- <th>alamat</th> -->
                <!-- <th>status</th> -->
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
    $(".card-table-pelamar").hide();

    $(".tda-form-filter-pelamar").on("submit", (e) => {
      e.preventDefault();
      $(".card-table-pelamar").show();
      const datatablesColumn = [{
          data: "DT_RowIndex",
          orderable: false,
          searchable: false
        },
        {
          data: "nama_and_id",
          render: (data) => {
            let redirectURL = "{{route('pelamar.detail', ':id')}}";
            redirectURL = redirectURL.replace(':id', data[1]);

            return `<a href="${redirectURL}" target="_blank" style="text-decoration: underline;">${data[0]}</a>`;
          }
        },
        {
          data: "label"
        },
        // {
        //   data: "jenjang",
        //   render: (data) => {
        //     return data.length ? data : "-";
        //   }
        // },
        {
          data: "jenis_kelamin",
          render: (data) => {
            return data == "laki_laki" ? "laki laki" : "perempuan";
          }
        },
        {
          data: "status_menikah",
          render: (data) => {
            return `<span>${data == 1 ? 'Sudah Menikah' : 'Belum Menikah'}</span>`
          }
        },
        {
          data: 'disc',
          render: (data) => {
            if (data == '-' || data == null) {
              return 'belum mengikuti test';
            } else {
              const disc = JSON.parse(data);
              let discResult = disc.judul;
              discResult = discResult.replace('Profile:', '');

              return discResult;
            }
          }
        },
        {
          data: 'jenjang',
          render: (data) => {
            const jenjang = JSON.parse(data);
            let title;
            jenjang.map((item, index) => {
              if (index < (jenjang.length - 1) && item.jenjang.length != 0) {
                title += item.jenjang + ' - ';
              } else if (item.jenjang.length != 0) {
                title += item.jenjang;
              } else {
                title += '-';
              }
            });
            title = title.replace('undefined', '');
            return title;
          }
        },
        // {
        //   data: "alamat"
        // },
        // {
        //   data: 'status',
        //   render: (data) => {
        //     const badgeColor = (data == 0) ? "danger" : (data == 1) ? "warning" : "success";
        //     const badgeMessage = (data == 0) ? "belum" : (data == 1) ? "sedang" : "selesai";
        //     return `<span class="bagde badge-${badgeColor} px-2 py-1 rounded-pill">${badgeMessage}</span>`;
        //   }
        // }
      ];

      if ($.fn.dataTable.isDataTable("#data-table-pelamar")) {
        $("#data-table-pelamar").DataTable().destroy();
        $("#data-table-pelamar").DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: {
            url: "{{route('datatables.pelamar')}}",
            type: "POST",
            data: {
              "_token": "{{ csrf_token() }}",
              interpretasi: $("select[name=interpretasi]").val(),
              jenjang: $("select[name=jenjang]").val(),
              status_menikah: $("input[name=status_menikah]:checked").val(),
              jenis_kelamin: $("input[name=jenis_kelamin]:checked").val(),
            },
          },
          columns: datatablesColumn
        });
      } else {
        $("#data-table-pelamar").DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: {
            url: "{{route('datatables.pelamar')}}",
            type: "POST",
            data: {
              "_token": "{{ csrf_token() }}",
              interpretasi: $("select[name=interpretasi]").val(),
              jenjang: $("select[name=jenjang]").val(),
              status_menikah: $("input[name=status_menikah]:checked").val(),
              jenis_kelamin: $("input[name=jenis_kelamin]:checked").val(),
            },
          },
          columns: datatablesColumn
        });
      }
    });

    $(".tda-export-excel").on("click", (e) => {
      const formData = $(".tda-form-filter-pelamar").serialize();
      let redirectURL = "{{route('pelamar.export.excel', ':data')}}";
      redirectURL = redirectURL.replace(":data", formData);

      window.open(redirectURL, "_blank");
      console.log(redirectURL);
    });

    $(".tda-export-pdf").on("click", (e) => {
      const formData = $(".tda-form-filter-pelamar").serialize();
      let redirectURL = "{{route('pelamar.export.pdf', ':data')}}";
      redirectURL = redirectURL.replace(":data", formData);

      window.open(redirectURL, "_blank");
      console.log(redirectURL);
    });
  });
</script>
@endpush