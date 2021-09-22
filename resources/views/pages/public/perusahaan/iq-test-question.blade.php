@extends('layout.public')

@section('content')
<div class="col-lg-10">
  <div class="card card-primary">
    <div class="card-header d-flex justify-content-between">
      <h4>{{$titlePage}}</h4>
      <h4 id="iq-test-timer"></h4>
    </div>
    <div class="card-body">
      <h4 class="text-center">{{$questionNumber}} dari 70 pertanyaan</h4>
      <div class="text-center">
        {!! $soal->desc_soal !!}
      </div>
      <form class="form_question" action="{{route('perusahaan.pelamar.test.iq.question.process', ['idPelamar' => $idPelamar, 'kodePelamar' => $kodePelamar, 'questionNumber' => $questionNumber])}}" method="post">
        @csrf
        <input type="hidden" name="ID_tiq_soal" value="{{$soal->ID_tiq_soal}}">
        <input type="hidden" name="time" class="time">
        @foreach($soal->opsi as $opsi)
        <div class="form-check">
          <input class="form-check-input" type="radio" name="ID_tiq_opsi" id="opsi" value="{{$opsi->ID_tiq_opsi}}" required>
          <label class="form-check-label" for="opsi">
            <h6>{{$opsi->desc_opsi}}</h6>
          </label>
        </div>
        @endforeach
        <div class="d-flex justify-content-end mt-5">
          <button type="submit" class="btn {{$questionNumber == 70 ? 'btn-success selesai' : 'btn-primary'}} text-capitalize">{{$questionNumber == 70 ? "Selesai" : "Selanjutnya"}}</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  const timerDuration = localStorage.getItem('TIMER_DURATION');
  const timerElement = document.querySelector('#iq-test-timer');
  const time = document.querySelector('.time');

  function startTimer(duration, display) {
    let minutes, seconds;
    const timerInterval = setInterval(function() {
    minutes = parseInt(duration / 60, 10);
    seconds = parseInt(duration % 60, 10);

    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    time.value = duration;
    --duration;
    display.textContent = `${minutes} : ${seconds}`;
    if (duration == 0){
      const requestURL = "{{route('perusahaan.pelamar.test.iq.question.process', ['idPelamar' => $idPelamar, 'kodePelamar' => $kodePelamar, 'questionNumber' => 71])}}";
      axios.post(requestURL, {
        time: time.value
      })
      .then((response) => {
        console.log(response);
        const redirectURL = "{{route('perusahaan.thank.you')}}";
        location.replace(redirectURL);
      })
      .catch(err => console.log(err));
      clearInterval(timerInterval);
    };
    localStorage.setItem("TIMER_DURATION", duration);
    }, 1000);

    const btnSelesai = document.querySelector('.btn.selesai');
    btnSelesai.addEventListener('click', (e) =>{
      const form = document.querySelector('.form_question');
      localStorage.removeItem('TIMER_DURATION');
      clearInterval(timerInterval);
    });
  }

  if (!timerDuration || timerDuration < 1) {
    startTimer(4500, timerElement);
  } else {
    startTimer(timerDuration, timerElement);
  }
</script>
@endpush