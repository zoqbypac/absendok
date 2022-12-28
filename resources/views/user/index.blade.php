<x-app-layout>
    <x-slot name="header">
        <form action="{{ route('userstore') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-4 gap-4">
                <div class="font-semibold text-3xl text-gray-800 leading-tight">
                    {{ __('Daftar User') }}
                </div>
                <div class="input-group">
                <input type="file" name="file" class="file-input file-input-bordered w-full max-w-xs" />
                <button type="submit" class="btn btn-primary">Upload</button>    
                </div>
            </div>
        </form>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-row">
                    <div class="basis-1/2">
                        <div class="px-4">
                        <table id="app" class="table">
                        <thead>
                            <tr>
                            <th>employee</th> 
                            <th>nama</th> 
                            <th>department</th> 
                            <th>aksi</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach ($user as $item)
                            <tr>
                                <td>{{ $item->employee }}</td>
                                <td>{{ $item->name }}</td> 
                                <td>{{ $item->department }}</td> 
                                <td>
                                    <a href="#my-modal-2" class="btn btn-sm btn-success">reset</a>
                                    <a href="{{ route('hapususer',$item->id) }}" class="btn btn-sm btn-secondary">Hapus</a>
                                      <!-- Put this part before </body> tag -->
                            <div class="modal" id="my-modal-2">
                                <div class="modal-box">
                                    <form action="{{ route('ubahpassword') }}" method="post">
                                        @csrf
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text">Password Baru</span>
                                            </label>
                                            <input type="text" name="password" id="password" class="input input-bordered">
                                        </div>
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <div class="modal-action">
                                            <button class="btn btn-sm btn-success">submit</button>
                                            <a href="#" class="btn btn-sm">batal</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                                </td> 
                            </tr>    
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="basis-1/2">
                        <table id="hak" class="table">
                            <thead>
                                <tr>
                                    <th>Hak Akses</th>
                                    <th>Cooming soon</th>
                                </tr>
                            </thead>
                            <tbody>
                               <tr>
                                <td></td>
                                <td></td>
                               </tr>
                            </tbody>
                        </table>
                    </div>
                </div>    
                
            </div>
        </div>
    </div>

 

    <script>
        $(document).ready( function () {
            $('#app').DataTable();
            // $('#hak').DataTable();
        });
    </script>
</x-app-layout>