@foreach ($chat as $i)
    <div class="chat {{ (($i->name == Auth::user()->name)? 'chat-end' : 'chat-start') }}">
        <div class="chat-image avatar">
            <div class="w-10 rounded-full">
                @if (str_contains($i->department, 'Dokter'))
                    <img src="{{ asset('img/doctor.png') }}"/>
                @else
                    <img src="{{ asset('img/employee.png') }}"/>
                @endif
            </div>
        </div>
        <div class="chat-header text-xs">
            {{ $i->name }}
        </div>
        <div
            class="chat-bubble {{ (($i->name == Auth::user()->name)? 'chat-bubble-accent' : 'chat-bubble-primary') }}">{{ $i->pesan }}</div>
        <div class="chat-footer">
            <time class="text-xs opacity-50">{{ date('H:i',strtotime($i->waktu)) }}</time>
        </div>
    </div>
@endforeach
