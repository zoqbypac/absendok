<x-app-layout>
    <x-slot name="header">
        <form action="{{ route('jadwalstore') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-4 gap-4">
                <div class="font-semibold text-3xl text-gray-800 leading-tight">
                    {{ __('Jadwal Dokter') }}
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
                @if ($gagal = Session::get('gagal'))
                <div class="alert alert-error shadow-lg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ $gagal }}</span>
                    </div>
                </div>
                @endif
                <div class="px-6 py-6">
                    <a href="#input-jadwal" class="btn btn-sm btn-primary">input</a>
                    <a href="#input-cuti" class="btn btn-sm btn-success" type="submit">cuti</a>
                    <a href="#input-tp" class="btn btn-sm btn-success" type="submit">tp</a>  
                    <a href="#hapus-jadwal" class="btn btn-sm btn-secondary" type="submit">hapus</a>
                    <a href="{{ route('xjadwaldokter') }}" class="btn btn-sm btn-info" type="submit">Eksport</a>  
                </div>
                    <!-- modal input jadwal dokter -->
                    <div class="modal" id="input-jadwal">
                        <div class="modal-box">
                            <form action="{{ route('inputjadwal') }}" method="post">
                            @csrf
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Nama Dokter</span>
                                </label>
                                <input list="dokters" name="namadokter" class="input input-bordered" />
                                        <datalist id="dokters">
                                            @foreach ($userdokter as $nama)
                                            <option value="{{ $nama->employee }}|{{ $nama->name }}">
                                            @endforeach
                                        </datalist>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Poliklinik</span>
                                </label>
                                <input list="poli" name="poliklinik" class="input input-bordered" />
                                    <datalist id="poli">
                                        @foreach ($poliklinik as $poli)
                                        <option value="{{ $poli->poliklinik }}">
                                        @endforeach
                                    </datalist>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Hari</span>
                                </label>
                                <select name="hari" class="select select-bordered">
                                    <option disabled selected>Pilih Hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Waktu</span>
                                </label>
                                <select name="waktu" class="select select-bordered">
                                    <option disabled selected>Pilih Waktu</option>
                                    <option value="Pagi">Pagi</option>
                                    <option value="Siang">Siang</option>
                                    <option value="Sore">Sore</option>
                                    <option value="Malam">Malam</option>
                                </select>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Jam Mulai</span>
                                </label>
                                <input type="time" name="jam_mulai" class="input input-bordered" />
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Jam selesai</span>
                                </label>
                                <input type="time" name="jam_selesai" class="input input-bordered" />
                            </div>
                            <div class="modal-action">
                                <button class="btn btn-sm btn-success">submit</button>
                                <a href="#" class="btn btn-sm">Batal</a>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- modal input jadwal cuti dokter --> 
                    <div class="modal" id="input-cuti">
                        <div class="modal-box">
                            <div class="font-semibold text-3xl text-gray-800 leading-tight">
                                {{ __('Input Jadwal Cuti') }}
                            </div>
                            <form action="{{ route('jadwalcuti') }}" method="post">
                                @csrf
                               <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Nama Dokter</span>
                                    </label>
                                    <input list="dokters" name="namadokter" class="input input-bordered" />
                                        <datalist id="dokters">
                                            @foreach ($dokter as $nama)
                                            <option value="{{ $nama->kodedokter }}|{{ $nama->namadokter }}">
                                            @endforeach
                                        </datalist>
                                </div>
                                <div class="form">
                                    <label class="label">
                                        <span class="label-text">Tanggal</span>
                                    </label>
                                    <input type="date" name="tglawal" id="tglawal" value="{{ request()->get('tglawal') ?? date('Y-m-d')}}" class="input input-bordered"> s.d. 
                                    <input type="date" name="tglakhir" id="tglakhir" value="{{ request()->get('tglakhir') ?? date('Y-m-d')}}" class="input input-bordered"> 
                                </div>
                                <div class="modal-action">
                                    <button class="btn btn-sm btn-success">submit</button>
                                    <a href="#" class="btn btn-sm">batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- modal input jadwal tp dokter --> 
                    <div class="modal" id="input-tp">
                        <div class="modal-box">
                            <div class="font-semibold text-3xl text-gray-800 leading-tight">
                                {{ __('Input Jadwal Tidak Praktek') }}
                            </div>
                            <form action="{{ route('jadwalcuti') }}" method="post">
                                @csrf
                               <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Nama Dokter</span>
                                    </label>
                                    <input list="namadokters" name="absenid" class="input input-bordered" />
                                        <datalist id="namadokters">
                                            @foreach ($absensi as $n)
                                            
                                            <option value="{{ $n->absenid }} | {{ $n->namadokter }} | {{ $n->hari }} : {{ $n->jam_mulai }}-{{ $n->jam_selesai }}">
                                            @endforeach
                                        </datalist>
                                </div>
                                <div class="modal-action">
                                    <button class="btn btn-sm btn-success">submit</button>
                                    <a href="#" class="btn btn-sm">batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- modal hapus jadwal dokter -->
                    <div class="modal" id="hapus-jadwal">
                        <div class="modal-box">
                            <form action="{{ route('hapusjadwal') }}" method="get">
                               <div class="form-control">
                                    <div class="alert alert-warning shadow-lg">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                            <span>Menghapus Seluruh jadwal berarti menghapus data dokter yang sudah absen hari ini !</span>
                                        </div>
                                    </div>
                                    <label class="label">
                                        <span class="label-text">Anda Yakin Ingin Menghapus Jadwal? Ketik ini: <strong>{{ $random }}</strong> </span>
                                    </label>
                                    <input type="hidden" name="random" value="{{ $random }}">
                                    <input type="text" name="konfirmasi" class="input input-bordered" />
                                </div>
                                <div class="modal-action">
                                    <button class="btn btn-sm btn-success">submit</button>
                                    <a href="#" class="btn btn-sm">batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                <div class="flex flex-row">
                    <div class="basis-3/4">
                        <div class="px-4">
                        <table id="app" class="table">
                        <thead>
                            <tr>
                            <th>kodedokter</th> 
                            <th>namadokter</th> 
                            <th>poliklinik</th> 
                            <th>hari</th> 
                            <th>waktu</th> 
                            <th>jam mulai</th> 
                            <th>jam selesai</th>
                            <th>aksi</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach ($jadwal as $item)
                            <tr>
                            <td>{{ $item->kodedokter }}</td>
                            <td>{{ $item->namadokter }}</td> 
                            <td>{{ $item->poliklinik }}</td> 
                            <td>{{ $item->hari }}</td> 
                            <td>{{ $item->waktu }}</td> 
                            <td>{{ $item->jam_mulai }}</td> 
                            <td>{{ $item->jam_selesai }}</td>
                            <td>
                                <a href="{{ route('ubahjadwal',$item->jadwalid) }}"class="btn btn-sm btn-info">Ubah</a>
                                <a href="{{ route('xhapusjadwal',$item->jadwalid) }}"class="btn btn-sm btn-secondary" onclick="return confirm('Anda yakin ingin menghapus jadwal dokter ini?') ">Hapus</a>
                            </td>
                            </tr>    
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="wrapper basis-1/4">
                        <div class="tabs">
                            <button data-id="cuti" class="tab tab-lifted tab-active">Cuti</button>
                            <button data-id="tp" class="tab tab-lifted">TP</button>
                        </div>
                        <div id=cuti class="content">
                            <table id="tdcuti" class="table">
                                <thead>
                                    <tr>
                                        <th>Dokter Cuti Hari ini</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cuti as $item)
                                    <tr>
                                        <td>{{ $item->namadokter }}</td>
                                        <td>
                                            <form action="{{ route('hapuscuti') }}" method="get">
                                            <input type="hidden" name="id" value="{{ $item->cutiid }}">
                                            <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Anda yakin ingin menghapus cuti {{ $item->namadokter }}?') ">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id=tp class="content hidden">
                            <table id="tdtp" class="table">
                                <thead>
                                    <tr>
                                        <th>Dokter Tidak praktik Hari ini</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absensi->where('keterangan','Tidak Praktek') as $item)
                                    <tr>
                                        <td>{{ $item->namadokter }}</td>
                                        <td>
                                            <form action="{{ route('hapuscuti') }}" method="get">
                                            <input type="hidden" name="absenid" value="{{ $item->absenid }}">
                                            <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Anda yakin ingin menghapus TP {{ $item->namadokter }}?') ">Hapus</button>
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
            $('#app').DataTable();
            $("#tdcuti").DataTable();
        });
        const tabs = document.querySelector(".wrapper");
        const tabButton = document.querySelectorAll(".tab");
        const contents = document.querySelectorAll(".content");

        tabs.onclick = e => {
            const id = e.target.dataset.id;

            if (id) {
                tabButton.forEach(btn => {
                    btn.classList.remove("tab-active");
                });
                e.target.classList.add("tab-active");

                contents.forEach(content => {
                    content.classList.add("hidden");
                });
                const element = document.getElementById(id);
                element.classList.remove("hidden");

            }
            if (id == 'cuti') {
                $("#tdcuti").DataTable();
            } else {
                $("#tdtp").DataTable();
            }

        }
    </script>
</x-app-layout>