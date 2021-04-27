<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Nama Member</th>
      <th>Nomor Member</th>
      <th>Kode Member</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($members as $loopItem)
    <tr>
      <td>{{$loop->iteration}}</td>
      <td>{{$loopItem->nama_member}}</td>
      <td>{{$loopItem->nomor_member}}</td>
      <td>{{$loopItem->kode_member}}</td>
      <td>
        @if($loopItem->status_aktivasi == 0)
        Belum Diproses
        @elseif($loopItem->status_aktivasi == 1)
        Aktif
        @else
        Di Tolak
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>