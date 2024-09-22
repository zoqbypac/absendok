<table class="table table-zebra">
    <thead>
    <tr>
        <th colspan="10">Rekap Absensi {{ $poli }} - {{ $tanggal }}</th>
    </tr>
    <tr>
        <th>Nama Dokter</th>
        <th>Jumlah Praktik</th>
        <th>Absensi</th>
        <th>Terlambat</th>
        <th>Eksklusi</th>
        <th>% Absensi</th>
        <th>% Terlambat</th>
        <th>rata rata</th>
        <th>total</th>
        <th>alasan terlambat</th>
    </tr>
    </thead>
    <tbody>
    @foreach($namadokter as $nama)
        <tr>
            <td>{{ $nama->namadokter }}</td>
            <td>{{ $absensi->where('namadokter', $nama->namadokter)->count() }}</td>
            <td>{{ $absensi->where('namadokter', $nama->namadokter)->where('jam_masuk','!=', null)->count() }}</td>
            <td>{{ $absensi->where('namadokter', $nama->namadokter)->where('keterangan','Terlambat')->count() }}</td>
            <td>{{ $absensi->where('namadokter', $nama->namadokter)->where('eksklusi',true)->count() }}</td>
            <td>
                @if($absensi->where('namadokter', $nama->namadokter)->count() > 0)
                    {{ round($absensi->where('namadokter', $nama->namadokter)->where('jam_masuk','!=', null)->count() / $absensi->where('namadokter', $nama->namadokter)->count() *100, 2) }}%
                @else
                    0%
                @endif
            </td>
            <td>
                @if($absensi->where('namadokter', $nama->namadokter)->where('jam_masuk','!=', null)->count() > 0)
                    {{ round(($absensi->where('namadokter', $nama->namadokter)->where('keterangan','Terlambat')->where('eksklusi',false)->count()) / $absensi->where('namadokter', $nama->namadokter)->where('jam_masuk','!=', null)->count() *100, 2) }}%
                @else
                    0%
                @endif
            </td>
            <td>{{ round($absensi->where('namadokter', $nama->namadokter)->where('jam_masuk','!=',null)->where('keterangan','Terlambat')->where('eksklusi',false)->average('selisih_masuk'),2) }} Menit</td>
            <td>{{ round($absensi->where('namadokter', $nama->namadokter)->where('jam_masuk','!=',null)->where('keterangan','Terlambat')->where('eksklusi',false)->sum('selisih_masuk'),2) }} Menit</td>
            <td>
                @foreach($alasan as $al)
                    @if($absensi->where('namadokter', $nama->namadokter)->where('status', $al->jenis_telat)->count() > 0)
                        {{ $al->jenis_telat }} = {{ $absensi->where('namadokter', $nama->namadokter)->where('status', $al->jenis_telat)->count() }},
                    @endif
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>TOTAL</td>
            <td>{{ $absensi->count() }}</td>
            <td>{{ $absensi->where('jam_masuk','!=', null)->count() }}</td>
            <td>{{ $absensi->where('keterangan','Terlambat')->count() }}</td>
            <td>{{ $absensi->where('eksklusi',true)->count() }}</td>
            <td>
                @if($absensi->count() > 0)
                    {{ round($absensi->where('jam_masuk','!=', null)->count() / $absensi->count() *100, 2) }}%
                @else
                    0%
                @endif
            </td>
            <td>
                @if($absensi->where('jam_masuk','!=', null)->count() > 0)
                    {{ round(($absensi->where('keterangan','Terlambat')->where('eksklusi',false)->count()) / $absensi->where('jam_masuk','!=', null)->count() *100, 2) }}%
                @else
                    0%
                @endif
            </td>
            <td>{{ round($absensi->where('jam_masuk','!=',null)->where('keterangan','Terlambat')->where('eksklusi',false)->average('selisih_masuk'),2) }} Menit</td>
            <td>{{ round($absensi->where('jam_masuk','!=',null)->where('keterangan','Terlambat')->where('eksklusi',false)->sum('selisih_masuk'),2) }} Menit</td>
            <td>
                @foreach($alasan as $al)
                    @if($absensi->where('status', $al->jenis_telat)->count() > 0)
                        {{ $al->jenis_telat }} = {{ $absensi->where('status', $al->jenis_telat)->count() }},
                    @endif
                @endforeach
            </td>
        </tr>
    </tfoot>
</table>
