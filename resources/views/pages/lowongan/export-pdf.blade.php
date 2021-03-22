<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export PDF | Daftar Lowongan</title>

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

  <h4>export PDF | daftar lowongan {{date('d F Y')}}</h4>

  <table border="1" cellspacing="0">
    <thead>
      <tr>
        <th>#</th>
        <th>nama lowongan</th>
        @if($user->role == 'admin') <th>nama member</th> @endif
        <th>tanggal publish</th>
        <th>status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($lowongan as $loopItem)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$loopItem->label}}</td>
        @if($user->role == 'admin') <td>{{$loopItem->member->nama_member}}</td> @endif
        <td>{{date_format($loopItem->created_at, 'd F Y')}}</td>
        <td style="text-transform: capitalize;">{{$loopItem->status_aktif ? 'aktif' : 'tidak aktif'}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>


  <footer>
    <p>&copy; copyright {{date('Y')}} TDA | recruitment</p>
  </footer>
</body>

</html>