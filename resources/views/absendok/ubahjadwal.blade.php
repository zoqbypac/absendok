<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ubah Jadwal Dokter') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 text-gray-900 flex justify-center">
                    <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
                        <div class="card-body">
                            <form action="{{ route('inputjadwal') }}" method="post">
                            @csrf
                            <input type="hidden" name="jadwalid" value="{{ $dokter->jadwalid }}">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Kode Dokter</span>
                                </label>
                                <input typr="text" name="kodedokter" class="input input-bordered" value="{{ $dokter->kodedokter }}" />
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Nama Dokter</span>
                                </label>
                                <input typr="text" name="namadokter" class="input input-bordered" value="{{ $dokter->namadokter }}" />
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Poliklinik</span>
                                </label>
                                <input list="poli" name="poliklinik" class="input input-bordered" value="{{ $dokter->poliklinik }}" />
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
                                    <option value="{{ $dokter->hari }}" selected>{{ $dokter->hari }}</option>
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
                                    <option value="{{ $dokter->waktu }}" selected>{{ $dokter->waktu }}</option>
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
                                <input type="time" name="jam_mulai" class="input input-bordered" value="{{ $dokter->jam_mulai }}" />
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Jam selesai</span>
                                </label>
                                <input type="time" name="jam_selesai" class="input input-bordered" value="{{ $dokter->jam_selesai }}" />
                            </div>
                            <div class="modal-action">
                                <button class="btn btn-sm btn-success">submit</button>
                                <a href="{{ route('jadwaldokter') }}" class="btn btn-sm">Batal</a>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>