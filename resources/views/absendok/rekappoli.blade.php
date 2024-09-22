<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <form action="{{ route('rekapabsenpoli') }}" method="GET">
                {{ __('Rekap Absensi Poliklinik: ') }}
                <input type="date" name="dari" id="dari" value="{{ request()->get('dari') ?? date('Y-m-d')}}"
                    class="input input-sm input-bordered"> -
                <input type="date" name="sampai" id="sampai" value="{{ request()->get('sampai') ?? date('Y-m-d')}}"
                    class="input input-sm input-bordered">
                <select name="poli" class="select select-sm select-bordered">
                    <option disabled selected>Pilih Poliklinik ...</option>
                    @foreach ($poli as $item)
                        <option value="{{$item->poliklinik}}" {{ (request()->poli == $item->poliklinik)?'selected':'' }}>{{ $item->poliklinik }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-sm btn-primary"
                    onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();">view</button>
                <button formaction="{{ route('xrekapabsenpoli') }}" class="btn btn-sm btn-secondary"
                    type="submit">Eksport</button>
                @if($errors->any())
                <div class="alert alert-error shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{$errors->first()}}</span>
                    </div>
                </div>
                @endif
            </form>
        </h2>
    </x-slot>
    @if (request()->poli)
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table table-zebra">
                        <thead>
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
                </div>
            </div>
        </div>
    </div>
    @endif

</x-app-layout>
