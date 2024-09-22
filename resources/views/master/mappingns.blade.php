<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mapping Nurse Station') }}
        </h2>
        @if ($sukses = Session::get('sukses'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ $sukses }}</span>
            </div>
        @endif
        @if ($gagal = Session::get('gagal'))
            <div class="alert alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ $gagal }}</span>
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- The button to open modal -->
                    <a href="#tambah-alasan" class="btn btn-sm btn-success mb-6">Tambah Mapping</a>
                    <!-- Put this part before </body> tag -->
                    <div class="modal" id="tambah-alasan">
                        <form action="{{ route('store.mappingns') }}" method="post" class="modal-box" autocomplete="off">
                            @csrf
                            <div class="form-control">
                                <label class="label" for="kode_ns">
                                    <span class="label-text">Nurse Station</span>
                                </label>
                                <select id="kode_ns" name="ns" class="select select-bordered">
                                    @foreach($ns as $n)
                                        <option value="{{ $n->kodens }}">{{ $n->namans }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-control">
                                <label class="label" for="poliklinik">
                                    <span class="label-text">Poliklinik</span>
                                </label>
                                <select type="text" id="poliklinik" name="poliklinik" class="select select-bordered">
                                    @foreach($poliklinik as $poli)
                                        <option value="{{ $poli->poliklinik }}">{{ $poli->poliklinik }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-control">
                                <label class="label" for="kasir">
                                    <span class="label-text">Kasir</span>
                                </label>
                                <input type="number" id="kasir" name="kasir" class="input input-bordered"/>
                            </div>
                            <div class="modal-action">
                                <button type="submit" class="btn btn-sm btn-success">Tambah</button>
                                <a href="#" class="btn btn-sm btn-error">Batal</a>
                            </div>
                        </form>
                    </div>
                    <div class="flex flex-row">
                        <div class="py-6 px-6 basis-1/3">
                            <div>Belum Mapping</div>
                            <table id="app" class="table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode NS</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($polibm as $i)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $i->poliklinik }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="divider divider-horizontal"></div>
                        <div class="py-6 px-6 basis-2/3">
                            <div>Sudah Mapping</div>
                            <div>
                                <table id="app" class="table">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode NS</th>
                                        <th>Nama NS</th>
                                        <th>Kasir</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($mappingns as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->poliklinik }}</td>
                                            <td>{{ $item->namans }}</td>
                                            <td>{{ $item->kasir }}</td>
                                            <td>
                                                <form action="" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-info" formmethod="get" formaction="{{ route('edit.mappingns',$item->idmapping) }}">edit</button>
                                                    <button type="submit" class="btn btn-sm btn-warning" formaction="{{ route('delete.mappingns',$item->idmapping) }}">Hapus</button>
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
    </div>
</x-app-layout>
