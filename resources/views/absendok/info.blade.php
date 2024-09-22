@foreach ($info as $i)
    <div class="chat {{ (str_contains($i->pesan, Auth::user()->name)? 'chat-end' : 'chat-start') }}">
        <div
            class="chat-bubble flex {{ (str_contains($i->pesan, 'Selesai')? 'chat-bubble-error' : 'chat-bubble-success') }}">
            <div class="badge badge-lg badge-accent mr-2">{{ date('H:i',strtotime($i->waktu)) }}</div>
            <div class="mr-2">{{ $i->pesan }}</div>
        </div>
    </div>
@endforeach
