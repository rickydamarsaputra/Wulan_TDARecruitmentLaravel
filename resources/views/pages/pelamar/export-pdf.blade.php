<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Pelamar {{date('dmy')}}</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      padding: 1.5rem;
    }

    h4 {
      text-transform: capitalize;
      margin-bottom: 1.5rem;
      text-align: center;
      font-weight: normal;
    }

    table {
      width: 100%;
    }

    table thead tr th,
    table tbody tr td {
      padding: .5rem;
      font-weight: normal;
      text-align: center;
    }

    table thead tr th {
      text-transform: capitalize;
    }

    footer {
      position: absolute;
      bottom: 0;
      border-top: 2px solid #333;
      padding-top: 0.5rem;
    }

    footer p {
      text-align: center;
      font-size: 0.8rem;
    }
  </style>
</head>

<body>
  <table border="1" cellspacing="0">
    <thead>
      <tr>
        <th>#</th>
        <th>nama</th>
        <th>lowongan</th>
        <th>jenis kelamin</th>
        <th>status menikah</th>
        <th>test DISC</th>
        <th>Jenjang</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pelamar as $loopItem)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$loopItem->nama_pelamar}}</td>
        <td>{{$loopItem->lowongan->label}}</td>
        <td>{{$loopItem->jenis_kelamin}}</td>
        <td>{{$loopItem->status_menikah == 1 ? 'Sudah Menikah' : 'Belum Menikah'}}</td>
        <td>{{!empty($loopItem->summary) && $loopItem->summary->ID_interpretasi != 0 ? str_replace('Profile:', '', $loopItem->summary->interpretasi->judul) : '-'}}</td>
        <td>
          @foreach($loopItem->pendidikanPelamar as $pendidikan)
          {{!$loop->last ? "$pendidikan->jenjang |" : "$pendidikan->jenjang"}}
          @endforeach
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <footer>
    <p>&copy; copyright {{date('Y')}} TDA | recruitment</p>
  </footer>
</body>

</html>