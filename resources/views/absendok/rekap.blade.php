<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <form action="{{ route('rekapabsen') }}" method="GET">
                {{ __('Rekap Absensi Dokter: ') }}
                <input type="date" name="dari" id="dari" value="{{ request()->get('dari') ?? date('Y-m-d')}}" class="input input-sm input-bordered"> - 
                <input type="date" name="sampai" id="sampai" value="{{ request()->get('sampai') ?? date('Y-m-d')}}" class="input input-sm input-bordered"> 
                <button type="submit" class="btn btn-sm btn-primary" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();">refresh</button>
                <button formaction="{{ route('xrekapabsen') }}" class="btn btn-sm btn-secondary" type="submit">Eksport</button>
                @if($errors->any())
                <div class="alert alert-error shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{$errors->first()}}</span>
                    </div>
                </div>
                @endif
            </form>
        </h2>
    </x-slot>
@if ($absen->count() > 0)
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table table-zebra table-compact">
                        <tr>
                                <td class="border-y border-l border-stone-400">Jumlah Jadwal</td>
                                <td class="border-y border-r border-stone-400">: {{ ($absen->count() - $cuti) }}</td>
                                <td class="border-y border-l border-r border-stone-400">Eksekutif: {{$absenekse}}</td>
                                <td class="border-y border-l border-r border-stone-400">Reguler: {{$absenreg}}</td>
                            </tr>
                            <tr>
                                <td class="border-y border-l border-stone-400">Jumlah Absen</td>
                                <td class="border-y border-stone-400">: {{ $jumlahabsen }}</td>
                                <td>({{ round(($jumlahabsen / ($absen->count() - $cuti) * 100),2) }}%)</td>
                                <td class="border-y border-l border-stone-400">Eksekutif: {{ $jumlahabsenekse }}</td>
                                @if ($absenekse>0)
                                <td class="border-y border-stone-400">({{ round(($jumlahabsenekse / $absenekse * 100),2) }}%)</td>
                                @endif
                                <td class="border-y border-l border-stone-400">Reguler: {{ $jumlahabsenreg }}</td>
                                @if ($absenreg>0)
                                <td class="border-y border-r border-stone-400">({{ round(($jumlahabsenreg / $absenreg * 100),2) }}%)</td>
                                @endif
                            </tr>
                            <tr>
                                <td class="border-y border-l border-stone-400">Terlambat</td>
                                <td class="border-y border-stone-400">: {{$terlambat}}</td>
                                @if ($jumlahabsen>0)
                                <td class="border-y border-stone-400">({{ round(($terlambat / $jumlahabsen * 100),2) }}%)</td>
                                @endif
                                <td class="border-y border-l border-stone-400">Eksekutif: {{$terlambatekse}}</td>
                                @if ($jumlahabsenekse>0)
                                <td class="border-y border-stone-400">({{ round(($terlambatekse / $jumlahabsenekse * 100),2) }}%)</td>
                                @endif
                                <td class="border-y border-l border-stone-400">Reguler: {{$terlambatreg}}</td>
                                @if ($jumlahabsenreg)
                                <td class="border-y border-r border-stone-400">({{ round(($terlambatreg / $jumlahabsenreg * 100),2) }}%)</td>
                                @endif
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
                                <td class="border-y border-stone-400">: {{ ($absen->count() - $cuti) - $jumlahabsen + $terlambat }}</td>
                                <td class="border-y border-stone-400">({{ round(((($absen->count() - $cuti) - $jumlahabsen + $terlambat)/ ($absen->count() - $cuti) * 100),2) }}%)</td>
                                <td class="border-y  border-l border-stone-400">Eksekutif: {{ $absenekse - $jumlahabsenekse + $terlambatekse }}</td>
                                @if ($absenekse>0)
                                <td class="border-y border-stone-400">({{ round((($absenekse - $jumlahabsenekse + $terlambatekse)/ $absenekse * 100),2) }}%)</td>
                                @endif
                                <td class="border-y  border-l border-stone-400">Reguler: {{ $absenreg - $jumlahabsenreg + $terlambatreg }}</td>
                                @if ($absenreg>0)
                                <td class="border-y border-r border-stone-400">({{ round((($absenreg - $jumlahabsenreg + $terlambatreg)/ $absenreg * 100),2) }}%)</td>
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
                                    <td>
                                        @if ($item->keterangan == 'Terlambat')
                                            <div class="text-red-500">Terlambat</div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#absendok').DataTable();
    </script>
@endif
    
</x-app-layout>