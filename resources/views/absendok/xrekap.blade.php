<table class="table table-zebra table-compact">
    <tr>
        <th>Rekap Absen</th>
        <th>: {{ $tanggal }}</th>
    </tr>
    <tr>
        <td>Jumlah Jadwal</td>
        <td>: {{ ($absen->count()-$cuti) }}</td>
        <td>Eksekutif: {{$absenekse}}</td>
        <td>Reguler: {{$absenreg}}</td>
    </tr>
    <tr>
        <td>Jumlah Absen</td>
        <td>: {{ $jumlahabsen }} ({{ round(($jumlahabsen / ($absen->count()-$cuti) * 100),2) }}%)</td>
        @if ($absenekse>0)
        <td>Eksekutif: {{ $jumlahabsenekse }} ({{ round(($jumlahabsenekse / $absenekse * 100),2) }}%)</td>
        @endif
        @if ($absenreg>0)
        <td>Reguler: {{ $jumlahabsenreg }} ({{ round(($jumlahabsenreg / $absenreg * 100),2) }}%)</td>
        @endif
    </tr>
    <tr>
        <td>Terlambat</td>
        @if ($jumlahabsen>0)
        <td>: {{$terlambat}} ({{ round(($terlambat / $jumlahabsen * 100),2) }}%)
        </td>
        @endif
        @if ($jumlahabsenekse>0)
        <td>Eksekutif: {{$terlambatekse}} ({{ round(($terlambatekse / $jumlahabsenekse * 100),2) }}%)</td>
        @endif
        @if ($jumlahabsenreg)
        <td>Reguler: {{$terlambatreg}} ({{ round(($terlambatreg / $jumlahabsenreg * 100),2) }}%)</td>
        @endif
    </tr>
    <tr>
        <td>Rata Rata Terlambat</td>
        <td>: {{ round($avg,2) }} Menit</td>
        <td>Eksekutif: {{ round($avgekse,2) }} Menit</td>
        <td>Reguler: {{ round($avgreg,2) }} Menit</td>
    </tr>
    <tr>
        <td>Terlambat (kumulatif)</td>
        <td>: {{ ($absen->count()-$cuti) - $jumlahabsen + $terlambat }}
            ({{ round(((($absen->count()-$cuti) - $jumlahabsen + $terlambat)/ ($absen->count()-$cuti) * 100),2) }}%)
        </td>
        @if ($absenekse>0)
        <td>Eksekutif:
            {{ $absenekse - $jumlahabsenekse + $terlambatekse }}
            ({{ round((($absenekse - $jumlahabsenekse + $terlambatekse)/ $absenekse * 100),2) }}%)
        </td>
        @endif
        @if ($absenreg>0)
        <td>Reguler:
            {{ $absenreg - $jumlahabsenreg + $terlambatreg }}
            ({{ round((($absenreg - $jumlahabsenreg + $terlambatreg)/ $absenreg * 100),2) }}%)</td>
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
