<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-3xl text-gray-800 leading-tight">
                    {{ __('Jadwal '.Auth::user()->name) }}
        </div>     
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto  px-6 py-6">
                <table class="table table-zebra">
                    
                    <tbody>
                        <tr>
                            <td>Senin</td>
                            <td>
                                @foreach ($senin as $item)
                                    {{ $item->poliklinik }}({{ date('H:i',strtotime($item->jam_mulai)) }} - {{ date('H:i',strtotime($item->jam_selesai)) }})<br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Selasa</td>
                            <td>
                                @foreach ($selasa as $item)
                                    {{ $item->poliklinik }}({{ date('H:i',strtotime($item->jam_mulai)) }} - {{ date('H:i',strtotime($item->jam_selesai)) }})<br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Rabu</td>
                            <td>
                                @foreach ($rabu as $item)
                                    {{ $item->poliklinik }}({{ date('H:i',strtotime($item->jam_mulai)) }} - {{ date('H:i',strtotime($item->jam_selesai)) }})<br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Kamis</td>
                            <td>
                                @foreach ($kamis as $item)
                                    {{ $item->poliklinik }}({{ date('H:i',strtotime($item->jam_mulai)) }} - {{ date('H:i',strtotime($item->jam_selesai)) }})<br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Jumat</td>
                            <td>
                                @foreach ($jumat as $item)
                                    {{ $item->poliklinik }}({{ date('H:i',strtotime($item->jam_mulai)) }} - {{ date('H:i',strtotime($item->jam_selesai)) }})<br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Sabtu</td>
                            <td>
                                @foreach ($sabtu as $item)
                                    {{ $item->poliklinik }}({{ date('H:i',strtotime($item->jam_mulai)) }} - {{ date('H:i',strtotime($item->jam_selesai)) }})<br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Minggu</td>
                            <td>
                                @foreach ($minggu as $item)
                                    {{ $item->poliklinik }}({{ date('H:i',strtotime($item->jam_mulai)) }} - {{ date('H:i',strtotime($item->jam_selesai)) }})<br>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table> 
                </div>   
            </div>
        </div>
    </div>
</x-app-layout>