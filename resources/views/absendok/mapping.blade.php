<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mapping Poliklinik') }}  
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-row">
                        <div class="py-6 px-6 basis-1/3">
                            Poliklinik Belum Mapping
                                <table id='belum' class='table'>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Poliklinik</th>
                                            <th>Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($belum as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->poliklinik }}</td>
                                            <td>
                                                <form action="{{ route('mappingstore') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->mapid }}">
                                                <button type="submit" name='kategori' value="Eksekutif" class="btn btn-sm btn-accent">Eksekutif</button>
                                                <button type="submit" name='kategori' value="Reguler" class="btn btn-sm btn-info">Reguler</button>
                                                </form>
                                            </td>
                                        </tr> 
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                        </div>
                        <div class="py-6 px-6 basis-1/3">
                            Poliklinik Eksekutif
                            <table id='eksekutif' class='table'>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Poliklinik</th>
                                            <th>Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($eksekutif as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->poliklinik }}</td>
                                            <td>
                                                <form action="{{ route('mappingstore') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->mapid }}">
                                                <button type="submit" name='kategori' value="Reguler" class="btn btn-sm btn-info">Pindah</button>
                                                <button type="submit" name='kategori' value="x" class="btn btn-sm btn-secondary">X</button>
                                                </form>
                                            </td>
                                        </tr> 
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                        </div>
                        <div class="py-6 px-6 basis-1/3">
                            Poliklinik Reguler
                            <table id='reguler' class='table'>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Poliklinik</th>
                                            <th>Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reguler as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->poliklinik }}</td>
                                            <td>
                                                <form action="{{ route('mappingstore') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->mapid }}">    
                                                <button type="submit" name='kategori' value="Eksekutif" class="btn btn-sm btn-accent">Pindah</button>
                                                <button type="submit" name='kategori' value="x" class="btn btn-sm btn-secondary">X</button>
                                                </form>
                                            </td>
                                        </tr> 
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {
            $('#belum').DataTable();
            $('#eksekutif').DataTable();
            $('#reguler').DataTable();
        });
    </script>
</x-app-layout>