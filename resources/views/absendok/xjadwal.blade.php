<table style="white-space: nowrap">
    <thead>
        <tr>
            <th>Kode Dokter</th>
            <th>Nama Dokter</th>
            <th>Poliklinik</th>
            <th>Hari</th>
            <th>Waktu</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jadwal as $item)
        <tr>
            <td>{{ $item->kodedokter }}</td>
            <td>{{ $item->namadokter }}</td>
            <td>{{ $item->poliklinik }}</td>
            <td>{{ $item->hari }}</td>
            <td>{{ $item->waktu }}</td>
            <td>{{ date('H:i',strtotime($item->jam_mulai)) }}</td>
            <td>{{ date('H:i',strtotime($item->jam_selesai)) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
