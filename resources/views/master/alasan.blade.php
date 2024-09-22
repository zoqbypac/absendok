<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jenis Alasan') }}
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
                    <a href="#tambah-alasan" class="btn btn-sm btn-success mb-6">Tambah alasan</a>
                    <!-- Put this part before </body> tag -->
                    <div class="modal" id="tambah-alasan">
                        <form action="{{ route('store.alasan') }}" method="post" class="modal-box" autocomplete="off">
                            @csrf
                            <div class="form-control">
                                <label class="label" for="jenis_alasan">
                                    <span class="label-text">Jenis Alasan</span>
                                </label>
                                <input type="text" id="jenis_alasan" name="jenis_telat" class="input input-bordered"/>
                            </div>
                            <div class="form-control">
                                <label class="label" for="eksklusi">
                                    <span class="label-text">Eksklusi</span>
                                </label>
                                <select id="eksklusi" name="eksklusi" class="select select-bordered">
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </div>

                            <div class="modal-action">
                                <button type="submit" class="btn btn-sm btn-success">Tambah</button>
                                <a href="#" class="btn btn-sm btn-error">Batal</a>
                            </div>
                        </form>
                    </div>
                    <table id="app" class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Alasan</th>
                            <th>Eksklusi</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($alasan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->jenis_telat }}</td>
                                <td>{{ ($item->eksklusi == true)?'Ya':'Tidak' }}</td>
                                <td>
                                    <form action="" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-info" formmethod="get" formaction="{{ route('edit.alasan',$item->id) }}">edit</button>
                                        <button type="submit" class="btn btn-sm btn-warning" formaction="{{ route('delete.alasan',$item->id) }}">Hapus</button>
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
</x-app-layout>
