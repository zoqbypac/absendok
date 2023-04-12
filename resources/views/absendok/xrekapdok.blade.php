<table class="table table-zebra table-compact">
    <tr>
        <th colspan="7">Rekap Absensi - {{$dokter}} - {{ $tanggal }}</th>
    </tr>
                        <tr>
                            <td class="border-y border-l border-stone-400">Jumlah Jadwal</td>
                            <td class="border-y border-r border-stone-400">: {{ ($absen->count() - $cuti->count()) }}
                            </td>
                            <td class="border-y border-l border-r border-stone-400">Eksekutif: {{$absenekse}}</td>
                            <td class="border-y border-l border-r border-stone-400">Reguler: {{$absenreg}}</td>
                        </tr>
                        <tr>
                            <td class="border-y border-l border-stone-400">Jumlah Absen</td>
                            <td class="border-y border-stone-400">: {{ $jumlahabsen }}</td>
                            <td class="border-y border-stone-400">
                            @if (($absen->count() - $cuti->count()) > 0)    
                                ({{ round(($jumlahabsen / ($absen->count() - $cuti->count()) * 100),2) }}%)
                            @endif
                            </td>
                            <td class="border-y border-l border-stone-400">Eksekutif: {{ $jumlahabsenekse }}</td>
                            <td class="border-y border-stone-400">
                            @if ($absenekse>0)    
                                ({{ round(($jumlahabsenekse / $absenekse * 100),2) }}%)
                            @endif
                            </td>
                            <td class="border-y border-l border-stone-400">Reguler: {{ $jumlahabsenreg }}</td>
                            <td class="border-y border-r border-stone-400">
                            @if ($absenreg>0)    
                                ({{ round(($jumlahabsenreg / $absenreg * 100),2) }}%)
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="border-y border-l border-stone-400">Jumlah Tidak Absen</td>
                            <td class="border-y border-stone-400">:
                                {{ ($absen->count() - $cuti->count() - $jumlahabsen )}}</td>
                            <td class="border-y border-stone-400">
                            @if (($absen->count() - $cuti->count()) > 0)
                                ({{ round((($absen->count() - $cuti->count() - $jumlahabsen ) / ($absen->count() - $cuti->count()) * 100),2) }}%)
                            @endif
                            </td>
                            <td class="border-y border-l border-stone-400">Eksekutif:
                                {{ $absenekse - $jumlahabsenekse }}</td>
                            <td class="border-y border-stone-400">
                            @if ($absenekse>0)    
                                ({{ round((($absenekse - $jumlahabsenekse) / $absenekse * 100),2) }}%)
                            @endif
                            </td>
                            <td class="border-y border-l border-stone-400">Reguler: {{ $absenreg - $jumlahabsenreg }}
                            </td>
                            <td class="border-y border-r border-stone-400">
                            @if ($absenreg>0)    
                                ({{ round((($absenreg - $jumlahabsenreg) / $absenreg * 100),2) }}%)
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="border-y border-l border-stone-400">Terlambat</td>
                            <td class="border-y border-stone-400">: {{$terlambat}}</td>
                            <td class="border-y border-stone-400">
                            @if ($jumlahabsen>0)    
                                ({{ round(($terlambat / $jumlahabsen * 100),2) }}%)
                            @endif
                            </td>
                            <td class="border-y border-l border-stone-400">Eksekutif: {{$terlambatekse}}</td>
                            <td class="border-y border-stone-400">
                            @if ($jumlahabsenekse>0)    
                                ({{ round(($terlambatekse / $jumlahabsenekse * 100),2) }}%)
                            @endif
                            </td>
                            <td class="border-y border-l border-stone-400">Reguler: {{$terlambatreg}}</td>
                            <td class="border-y border-r border-stone-400">
                            @if ($jumlahabsenreg)    
                                ({{ round(($terlambatreg / $jumlahabsenreg * 100),2) }}%)
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="border-y border-l border-stone-400">Rata Rata Terlambat</td>
                            <td class="border-y border-stone-400">: {{ round($avg,2) }}</td>
                            <td class="border-y border-stone-400">Menit</td>
                            <td class="border-y  border-l border-stone-400">Eksekutif: {{ round($avgekse,2) }}</td>
                            <td class="border-y border-stone-400">Menit</td>
                            <td class="border-y  border-l border-stone-400">Reguler: {{ round($avgreg,2) }}</td>
                            <td class="border-y border-r border-stone-400">Menit</td>
                        </tr>
                        <tr>
                            <td class="border-y border-l border-stone-400">Terlambat (kumulatif)</td>
                            <td class="border-y border-stone-400">:
                                {{ ($absen->count() - $cuti->count()) - $jumlahabsen + $terlambat }}</td>
                            <td class="border-y border-stone-400">
                            @if (($absen->count() - $cuti->count()) > 0)    
                                ({{ round(((($absen->count() - $cuti->count()) - $jumlahabsen + $terlambat)/ ($absen->count() - $cuti->count()) * 100),2) }}%)
                            @endif
                            </td>
                            <td class="border-y  border-l border-stone-400">Eksekutif:
                                {{ $absenekse - $jumlahabsenekse + $terlambatekse }}</td>
                            <td class="border-y border-stone-400">
                            @if ($absenekse>0)
                                ({{ round((($absenekse - $jumlahabsenekse + $terlambatekse)/ $absenekse * 100),2) }}%)
                            @endif
                            </td>
                            <td class="border-y  border-l border-stone-400">Reguler:
                                {{ $absenreg - $jumlahabsenreg + $terlambatreg }}</td>
                            <td class="border-y border-r border-stone-400">
                            @if ($absenreg>0)    
                                ({{ round((($absenreg - $jumlahabsenreg + $terlambatreg)/ $absenreg * 100),2) }}%)
                            @endif
                            </td>
                        </tr>
                    </table>

<div>
    <table>
            <tr>
                <th colspan="10">Dokter Absen</th>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>Nama Dokter</td>
                <td>Poliklinik</td>
                <td>Jam Mulai</td>
                <td>Jam Masuk</td>
                <td>Selisih</td>
                <td>Jam Selesai</td>
                <td>Jam Pulang</td>
                <td>Selisih</td>
                <td>Keterangan</td>
            </tr>
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
    <table>
            <tr>
                <th colspan="6">Dokter Tidak Absen</th>
            </tr>
            <tr>
                <td>kodedokter</td>
                <td>Nama Dokter</td>
                <td>Poliklinik</td>
                <td>Jam Mulai</td>
                <td>Jam Selesai</td>
                <td>Keterangan</td>
            </tr>
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
    <table>
            <tr>
                <th colspan="6">Dokter Tidak Praktik</th>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>Nama Dokter</td>
                <td>Poliklinik</td>
                <td>Jam Mulai</td>
                <td>Jam Selesai</td>
                <td>Keterangan</td>
            </tr>
            @foreach ($absen->whereIn('keterangan',['Cuti','Tidak Praktek']) as $item)
            <tr>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->namadokter }}</td>
                <td>{{ $item->poliklinik }}</td>
                <td>{{ $item->jam_mulai }}</td>
                <td>{{ $item->jam_selesai }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
    </table>
</div>
