@extends('layout.public')

@section('content')
<div class="col-lg-10 align-items-center">
  <div class="card card-primary">
    <div class="text-uppercase text-center mt-4">
      <h4 class="text-primary">disc</h4>
      <p>personality system graph page</p>
      <div class="tda__line__break"></div>
    </div>
    <div class="card-body">
      <div class="tda__pelamar__info">
        <h4>nama <span>{{$pelamar->nama_pelamar}}</span></h4>
        <h4>umur <span>{{date('Y') - date('Y', strtotime($pelamar->tanggal_lahir))}}</span></h4>
        <h4>jenis kelamin <span>{{$pelamar->jenis_kelamin != 'laki_laki' ? 'perempuan' : 'laki-laki'}}</span></h4>
        <h4>tanggal test <span>{{date_format($pelamar->summary->created_at, 'd F Y')}}</span></h4>
      </div>
    </div>
    <div class="tda__disc__table__container">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th scope="col">LINE</th>
            <th scope="col">D</th>
            <th scope="col">I</th>
            <th scope="col">S</th>
            <th scope="col">C</th>
            <th scope="col">*</th>
            <th scope="col">TOTAL</th>
          </tr>
        </thead>
        <tbody class="font-weight-bold">
          <tr>
            <td>1</td>
            <td>{{$pelamarSummary->m_d}}</td>
            <td>{{$pelamarSummary->m_i}}</td>
            <td>{{$pelamarSummary->m_s}}</td>
            <td>{{$pelamarSummary->m_c}}</td>
            <td>{{$pelamarSummary->m_st}}</td>
            <td class="text-danger">24</td>
          </tr>
          <tr>
            <td>2</td>
            <td>{{$pelamarSummary->l_d}}</td>
            <td>{{$pelamarSummary->l_i}}</td>
            <td>{{$pelamarSummary->l_s}}</td>
            <td>{{$pelamarSummary->l_c}}</td>
            <td>{{$pelamarSummary->l_st}}</td>
            <td class="text-danger">24</td>
          </tr>
          <tr>
            <td>3</td>
            <td>{{$pelamarSummary->c_d}}</td>
            <td>{{$pelamarSummary->c_i}}</td>
            <td>{{$pelamarSummary->c_s}}</td>
            <td>{{$pelamarSummary->c_c}}</td>
            <td class="bg-secondary"></td>
            <td class="bg-secondary"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="tda__disc__graph__container" x-data="{ graphOpen: 'most' }">
      <div class="tda__line__break"></div>
      <div class="d-flex justify-content-center">
        <button type="button" :class="{ 'btn-primary': graphOpen == 'most' }" @click=" graphOpen = 'most' " class="btn text-capitalize">most</button>
        <button type="button" :class="{ 'btn-primary': graphOpen == 'least' }" @click=" graphOpen = 'least' " class="btn text-capitalize mx-2">least</button>
        <button type="button" :class="{ 'btn-primary': graphOpen == 'change' }" @click=" graphOpen = 'change' " class="btn text-capitalize">change</button>
      </div>
      <div class="tda__disc__graph__most" x-show=" graphOpen == 'most' ">
        <div class="header">
          <h4>graph 1 most</h4>
          <p>mask public self</p>
        </div>
        <canvas id="graph_most" width="400" height="200"></canvas>
      </div>
      <div class="tda__disc__graph__least" x-show=" graphOpen == 'least' ">
        <div class="header">
          <h4>graph 1 least</h4>
          <p>core private self</p>
        </div>
        <canvas id="graph_least" width="400" height="200"></canvas>
      </div>
      <div class="tda__disc__graph__change" x-show=" graphOpen == 'change' ">
        <div class="header">
          <h4>graph 1 change</h4>
          <p>mirror perceived self</p>
        </div>
        <canvas id="graph_change" width="400" height="200"></canvas>
      </div>
    </div>
    <div class="tda__disc__keperibadian__job__match">
      <div class="tda__line__break"></div>
      <div class="deskripsi__keperibadian">
        <h4>deskripsi kepribadian</h4>
        <p>{{$pelamarSummary->interpretasi->deskripsi ?? ''}}</p>
      </div>
      <div class="job_match">
        <h4>job match</h4>
        <p>{{$pelamarSummary->interpretasi->job_match ?? ''}}</p>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    const defaultMost = [-6.0, -7.0, -5.7, -6.0];
    const defaultLeast = [7.5, 7.0, 7.5, 7.5];
    const defaultChange = [0.0, 0.5, 1.0, 1.5];

    let mostDISC = JSON.parse('{!! $mostDISC !!}');
    let leastDISC = JSON.parse('{!! $leastDISC !!}');
    let changeDISC = JSON.parse('{!! $changeDISC !!}');
    console.log(mostDISC);
    mostDISC = mostDISC.map((data, i) => Number((defaultMost[i] + Number(data)).toFixed(1)));
    console.log(mostDISC);
    leastDISC = leastDISC.map((data, i) => Number((defaultLeast[i] - Number(data)).toFixed(1)));
    changeDISC = changeDISC.map((data, i) => Number((defaultChange[i] + Number(data)).toFixed(1)));

    const graphMost = document.getElementById('graph_most').getContext('2d');
    const graphLeast = document.getElementById('graph_least').getContext('2d');
    const graphChange = document.getElementById('graph_change').getContext('2d');

    const generateChart = (chartElement, dataChart) => {
      return new Chart(chartElement, {
        type: 'line',
        data: {
          labels: ['D', 'I', 'S', 'C'],
          datasets: [{
            data: dataChart,
            fill: false,
            borderColor: [
              'rgba(0, 0, 0, 0.5)',
            ],
            pointBackgroundColor: [
              'rgba(0, 0, 0, 0.8)',
              'rgba(0, 0, 0, 0.8)',
              'rgba(0, 0, 0, 0.8)',
              'rgba(0, 0, 0, 0.8)',
            ],
            lineTension: 0,
            borderWidth: 2,
            pointRadius: 10,
            pointHoverRadius: 15
          }]
        },
        options: {
          legend: {
            display: false
          },
          tooltips: {
            callbacks: {
              title: (item, data) => {
                return `Series 1 Point "${item[0].label}"`;
              },
              label: (item, data) => {
                return `Value : ${item.value}`;
              }
            },
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
    }

    const chartMost = generateChart(graphMost, mostDISC);
    const chartLeast = generateChart(graphLeast, leastDISC);
    const chartChange = generateChart(graphChange, changeDISC);
  });
</script>
@endpush

@push('styles')
<style>
  .tda__line__break {
    width: 100%;
    height: 2px;
    background: #ACACAC;
    margin-bottom: 2rem;
  }

  .text-uppercase.text-center.mt-4 {
    padding: 0 1.5rem;
  }

  .tda__pelamar__info h4 {
    position: relative;
    font-weight: normal;
    font-size: 1rem;
    text-transform: capitalize;
  }

  .tda__pelamar__info h4::after {
    content: ':';
    position: absolute;
    left: 10rem;
    font-weight: bold;
  }

  .tda__pelamar__info h4 span {
    position: absolute;
    left: 12rem;
  }

  .tda__disc__graph__container,
  .tda__disc__table__container {
    margin-bottom: 2rem;
    padding: 0 1.5rem
  }

  .tda__disc__graph__most .header,
  .tda__disc__graph__least .header,
  .tda__disc__graph__change .header {
    padding: 1rem 0;
    margin: 1rem 0;
    border: 2px solid #ACACAC;
    text-align: center;
  }

  .tda__disc__graph__most .header h4,
  .tda__disc__graph__most .header p,
  .tda__disc__graph__least .header h4,
  .tda__disc__graph__least .header p,
  .tda__disc__graph__change .header h4,
  .tda__disc__graph__change .header p {
    font-size: .8rem;
    margin: 0;
    text-transform: uppercase;
    font-weight: bold;
  }

  .tda__disc__graph__most canvas,
  .tda__disc__graph__least canvas,
  .tda__disc__graph__change canvas {
    margin-top: 2rem;
  }

  .tda__disc__keperibadian__job__match {
    padding: 0 1.5rem;
  }

  .tda__disc__keperibadian__job__match .deskripsi__keperibadian h4,
  .tda__disc__keperibadian__job__match .job_match h4 {
    text-transform: capitalize;
    font-weight: normal;
    font-size: 1.2rem;
  }

  .tda__disc__keperibadian__job__match .deskripsi__keperibadian p,
  .tda__disc__keperibadian__job__match .job_match p {
    line-height: 1.1rem;
  }
</style>
@endpush