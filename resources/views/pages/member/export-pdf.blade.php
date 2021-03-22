<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export PDF | Daftar Member</title>

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

  <h4>export PDF | daftar member {{date('d F Y')}}</h4>

  <table border="1" cellspacing="0">
    <thead>
      <tr>
        <th>#</th>
        <th>nama member</th>
        <th>nomor member</th>
        <th>nama bisnis</th>
        <th>kode member</th>
      </tr>
    </thead>
    <tbody>
      @foreach($member as $loopItem)
      <tr>
        <th>{{$loop->iteration}}</th>
        <td>{{$loopItem->nama_member}}</td>
        <td>{{$loopItem->nomor_member}}</td>
        <td>{{$loopItem->nama_bisnis}}</td>
        <td>{{$loopItem->kode_member}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>


  <footer>
    <p>&copy; copyright {{date('Y')}} TDA | recruitment</p>
  </footer>
</body>

</html>