<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Nama Lowongan</th>
      @if(auth()->user()->role == 'admin')
      <th>Nama Member</th>
      @endif
      <th>Tanggal Publish</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($lowongan as $loopItem)
    <tr>
      <th>{{$loop->iteration}}</th>
      <th>{{$loopItem->label}}</th>
      @if(auth()->user()->role == 'admin')
      <th>{{$loopItem->member->nama_member}}</th>
      @endif
      <th>{{date_format($loopItem->created_at, 'd F Y')}}</th>
      <th>{{$loopItem->status_aktif ? 'Aktif' : 'Tidak Aktif'}}</th>
    </tr>
    @endforeach
  </tbody>
</table>