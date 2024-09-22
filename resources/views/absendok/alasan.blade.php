<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Penyebab Terlambat
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 items-center">
                    <form action="{{ route('alasan.terlambat',$jadwal->absenid) }}" method="post">
                        @csrf
                        <div class="form-control w-full max-w-xs">
                            <label class="label" for="alasan">
                                <span class="label-text">Penyebab Terlambat</span>
                            </label>
                            <select id="alasan" name="alasan" class="select select-bordered">
                                @foreach($alasan as $al)
                                    <option value="{{ $al->id }}">{{ $al->jenis_telat }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary mt-2">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
