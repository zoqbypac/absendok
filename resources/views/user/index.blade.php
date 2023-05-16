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
                @if ($sukses = Session::get('sukses'))
                <div class="alert alert-success shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ $sukses }}</span>
                    </div>
                </div>
                @endif
                <div class="flex flex-row">
                    <div class="basis-1/2">
                        <div class="px-4 py-4">
                            <!-- The button to open modal -->
                            <a href="#my-modal-2" class="btn btn-sm btn-success mb-6">Tambah user</a>
                            <!-- Put this part before </body> tag -->
                            <div class="modal" id="my-modal-2">
                                <form action="{{ route('register') }}" method="post" class="modal-box">
                                    @csrf
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Employee</span>
                                        </label>
                                        <input type="text" name="employee" class="input input-bordered" />
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Nama</span>
                                        </label>
                                        <input type="text" name="name" class="input input-bordered" />
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Department</span>
                                        </label>
                                        <select name="department" class="select select-bordered">
                                            <option value="Bidang Keperawatan">Bidang Keperawatan</option>
                                            <option value="Bagian Mutu dan Akreditasi">Bagian Mutu dan Akreditasi</option>
                                            <option value="Bagian Personalia">Bagian Personalia</option>
                                            <option value="Direksi RS">Direksi RS</option>
                                            <option value="Dokter Spesialis">Dokter Spesialis</option>
                                            <option value="Front Office Customer Service">Front Office Customer Service</option>
                                            <option value="IT Support">IT Support</option>
                                        </select>
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Password</span>
                                        </label>
                                        <input type="password" name="password" class="input input-bordered" />
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
                                            <a href="#{{ $item->employee }}" class="btn btn-sm btn-success">reset</a>
                                            <a href="{{ route('hapususer',$item->id) }}"
                                                class="btn btn-sm btn-secondary"
                                                onclick="return confirm('Anda yakin ingin menghapus user ini?') ">Hapus</a>
                                            <!-- Put this part before </body> tag -->
                                            <div class="modal" id="{{ $item->employee }}">
                                                <div class="modal-box">
                                                    <form action="{{ route('ubahpassword') }}" method="post">
                                                        @csrf
                                                        <div class="form-control">
                                                            <label class="label">
                                                                <span class="label-text">Password Baru</span>
                                                            </label>
                                                            <input type="password" name="password" id="password"
                                                                class="input input-bordered">
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
                        
                    </div>
                </div>

            </div>
        </div>
    </div>



    <script>
        $(document).ready(function () {
            $('#app').DataTable();
            // $('#hak').DataTable();
        });

    </script>
</x-app-layout>
