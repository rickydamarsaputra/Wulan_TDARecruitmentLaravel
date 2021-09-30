@extends('layout.dashboard')
@section('title', 'Iq Test Update Soal')

@section('content')
<section class="section">
  <div class="section-header text-capitalize d-flex justify-content-between">
    <h1>Update Soal Iq Test</h1>
    <a href="{{route('iq-question.index')}}" class="btn btn-primary">kembali</a>
  </div>
  <div class="card">
    <div class="card-body">
      <form action="{{route('iq-question.update.action', $soal->ID_tiq_soal)}}" method="post">
        @method('put')
        @csrf
        <div class="form-group">
          <label for="deskripsi_soal">Deskripsi Soal</label>
          <textarea name="deskripsi_soal" id="deskripsi_soal">{{ $soal->desc_soal }}</textarea>
        </div>
        <div class="form-group">
          <label for="poin_benar">Point Benar</label>
          <input name="poin_benar" id="poin_benar" type="text" class="form-control" placeholder="masukkan point..." value="{{ $soal->poin_benar }}">
        </div>
        <div class="form-group">
          <label for="poin_benar">Opsi Jawaban</label>
          <div class="opsi-jawaban-container">
            @foreach ($soal->opsi as $index => $loopItem)
              @if ($loopItem->ID_tiq_opsi == $soal->jawaban_benar)
                <div class="form-check d-flex align-items-center mb-3" data-container-id="{{ $index }}">
                  <input class="form-check-input" type="radio" name="jawaban_benar" value="{{ $loopItem->ID_tiq_opsi }}" checked>
                  <input name="opsi_text[]" id="opsi_text" type="text" class="form-control" placeholder="masukkan opsi jawaban..." value="{{ $loopItem->desc_opsi }}">
                  <button type="button" class="btn btn-sm btn-danger ml-2 delete-opsi" data-id="{{ $index }}"><i class="fas fa-times"></i></button>
                </div>
              @else
                <div class="form-check d-flex align-items-center mb-3" data-container-id="{{ $index }}">
                  <input class="form-check-input" type="radio" name="jawaban_benar" value="{{ $loopItem->ID_tiq_opsi }}">
                  <input name="opsi_text[]" id="opsi_text" type="text" class="form-control" placeholder="masukkan opsi jawaban..." value="{{ $loopItem->desc_opsi }}">
                  <button type="button" class="btn btn-sm btn-danger ml-2 delete-opsi" data-id="{{ $index }}"><i class="fas fa-times"></i></button>
                </div>
              @endif
            @endforeach
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-success ml-2 tambah-opsi"><i class="fas fa-plus"></i> Tambah Opsi Jawaban</button>
      </form>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script>
  $(document).ready(() => {
    let opsiID = (Number("{{ count($soal->opsi) }}"));
    CKEDITOR.replace('deskripsi_soal');

    $('.tambah-opsi').on('click', (e) => {
      const opsiElement = `
        <div class="form-check d-flex align-items-center mb-3" data-container-id=${opsiID}>
          <input class="form-check-input" type="radio" name="opsi_jawaban" value="${opsiID}">
          <input name="opsi_text[]" id="opsi_text" type="text" class="form-control" placeholder="masukkan opsi jawaban...">
          <button type="button" class="btn btn-sm btn-danger ml-2 delete-opsi" data-id=${opsiID}><i class="fas fa-times"></i></button>
        </div>
      `;

      $('.opsi-jawaban-container').append(opsiElement);
      $('.delete-opsi').on('click', function(e) {
        const dataID = $(this).attr('data-id');
        $(`[data-container-id=${dataID}]`).remove();
      });
      opsiID++;
    });
  });
</script>
@endpush