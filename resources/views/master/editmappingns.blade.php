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
                    <form action="{{ route('update.mappingns',$mappingns->id) }}" method="post" class="modal-box" autocomplete="off">
                        @csrf
                        @method('PATCH')
                        <div class="form-control">
                            <label class="label" for="kode_ns">
                                <span class="label-text">Nurse Station</span>
                            </label>
                            <select id="kode_ns" name="ns" class="select select-bordered">
                                @foreach($ns as $n)
                                    <option value="{{ $n->kodens }}" {{ ($mappingns->ns == $n->kodens)? 'selected': '' }}>{{ $n->namans }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label" for="poliklinik">
                                <span class="label-text">Poliklinik</span>
                            </label>
                            <select type="text" id="poliklinik" name="poliklinik" class="select select-bordered">
                                @foreach($poliklinik as $poli)
                                    <option value="{{ $poli->poliklinik }}" {{ ($mappingns->poliklinik == $poli->poliklinik)? 'selected' : '' }}>{{ $poli->poliklinik }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label" for="kasir">
                                <span class="label-text">Kasir</span>
                            </label>
                            <input type="number" id="kasir" name="kasir" class="input input-bordered" value="{{ $mappingns->kasir }}"/>
                        </div>

                        <div class="modal-action">
                            <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                            <a href="{{ route('index.mappingns') }}" class="btn btn-sm btn-error">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
