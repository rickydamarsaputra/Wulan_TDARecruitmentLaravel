<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TDA | Email Template</title>
</head>

<body>
  {!! $data['message'] !!}
  @if(!empty($data['kodePelamar']))
  <a href="{{route('pelamar.detail', $data['kodePelamar'])}}">click disini untuk melihat profile pelamar (pastikan anda sudah login di TDA Requitment)</a>
  @endif
</body>

</html>