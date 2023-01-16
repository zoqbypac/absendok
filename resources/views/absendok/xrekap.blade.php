<table class="table table-zebra table-compact">
    <tr>
        <td>Jumlah Jadwal</td>
        <td>: {{ ($absen->count() - $cuti->count()) }}</td>
        <td>Eksekutif: {{$absenekse}}</td>
        <td>Reguler: {{$absenreg}}</td>
    </tr>
    <tr>
        <td>Jumlah Absen</td>
        <td>: {{ $jumlahabsen }}</td>
        <td>({{ round(($jumlahabsen / ($absen->count() - $cuti->count()) * 100),2) }}%)</td>
        <td>Eksekutif: {{ $jumlahabsenekse }}</td>
        @if ($absenekse>0)
        <td>({{ round(($jumlahabsenekse / $absenekse * 100),2) }}%)</td>
        @endif
        <td>Reguler: {{ $jumlahabsenreg }}</td>
        @if ($absenreg>0)
        <td>({{ round(($jumlahabsenreg / $absenreg * 100),2) }}%)</td>
        @endif
    </tr>
    <tr>
        <td>Jumlah Tidak Absen</td>
        <td>: {{ ($absen->count() - $cuti->count() - $jumlahabsen )}}</td>
        <td>({{ round((($absen->count() - $cuti->count() - $jumlahabsen ) / ($absen->count() - $cuti->count()) * 100),2) }}%)
        </td>
        <td>Eksekutif: {{ $absenekse - $jumlahabsenekse }}</td>
        @if ($absenekse>0)
        <td>({{ round((($absenekse - $jumlahabsenekse) / $absenekse * 100),2) }}%)</td>
        @endif
        <td>Reguler: {{ $absenreg - $jumlahabsenreg }}</td>
        @if ($absenreg>0)
        <td>({{ round((($absenreg - $jumlahabsenreg) / $absenreg * 100),2) }}%)</td>
        @endif
    </tr>
    <tr>
        <td>Terlambat</td>
        <td>: {{$terlambat}}</td>
        @if ($jumlahabsen>0)
        <td>({{ round(($terlambat / $jumlahabsen * 100),2) }}%)</td>
        @endif
        <td>Eksekutif: {{$terlambatekse}}</td>
        @if ($jumlahabsenekse>0)
        <td>({{ round(($terlambatekse / $jumlahabsenekse * 100),2) }}%)</td>
        @endif
        <td>Reguler: {{$terlambatreg}}</td>
        @if ($jumlahabsenreg)
        <td>({{ round(($terlambatreg / $jumlahabsenreg * 100),2) }}%)</td>
        @endif
    </tr>
    <tr>
        <td>Rata Rata Terlambat</td>
        <td>: {{ round($avg,2) }}</td>
        <td>Menit</td>
        <td>Eksekutif: {{ round($avgekse,2) }}</td>
        <td>Menit</td>
        <td>Reguler: {{ round($avgreg,2) }}</td>
        <td>Menit</td>
    </tr>
    <tr>
        <td>Terlambat (kumulatif)</td>
        <td>: {{ ($absen->count() - $cuti->count()) - $jumlahabsen + $terlambat }}</td>
        <td>({{ round(((($absen->count() - $cuti->count()) - $jumlahabsen + $terlambat)/ ($absen->count() - $cuti->count()) * 100),2) }}%)
        </td>
        <td>Eksekutif: {{ $absenekse - $jumlahabsenekse + $terlambatekse }}</td>
        @if ($absenekse>0)
        <td>({{ round((($absenekse - $jumlahabsenekse + $terlambatekse)/ $absenekse * 100),2) }}%)</td>
        @endif
        <td>Reguler: {{ $absenreg - $jumlahabsenreg + $terlambatreg }}</td>
        @if ($absenreg>0)
        <td>({{ round((($absenreg - $jumlahabsenreg + $terlambatreg)/ $absenreg * 100),2) }}%)</td>
        @endif
    </tr>
</table>
<div class="mt-2 overflow-x-auto">
    <table id="absendok" class="table w-full">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Dokter</th>
                <th>Poliklinik</th>
                <th>Jam Mulai</th>
                <th>Jam Masuk</th>
                <th>Selisih</th>
                <th>Jam Selesai</th>
                <th>Jam Pulang</th>
                <th>Selisih</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absen->where('jam_masuk','!=',null) as $item)
            <tr>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->namadokter }}</td>
                <td>{{ $item->poliklinik }}</td>
                <td>{{ $item->jam_mulai }}</td>
                <td>{{ $item->jam_masuk }}</td>
                <td>{{ $item->selisih_masuk }} Menit</td>
                <td>{{ $item->jam_selesai }}</td>
                <td>{{ $item->jam_pulang }}</td>
                <td>{{ $item->selisih_pulang }} Menit</td>
                <td>
                    @if ($item->keterangan == 'Terlambat')
                    <div class="text-red-500">Terlambat</div>
                    @endif
                </td>
            </tr>
            @endforeach

    </table>
    <table id="tdtidakabsen" class="table w-full">
        <thead>
            <tr>
                <th>kodedokter</th>
                <th>Nama Dokter</th>
                <th>Poliklinik</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absen->where('jam_masuk',null)->where('keterangan',null) as $item)
            <tr>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->namadokter }}</td>
                <td>{{ $item->poliklinik }}</td>
                <td>{{ $item->jam_mulai }}</td>
                <td>{{ $item->jam_selesai }}</td>
                <td>Dokter Tidak Absen</td>
            </tr>
            @endforeach
    </table>
</div>
