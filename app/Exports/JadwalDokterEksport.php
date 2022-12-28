<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class JadwalDokterEksport implements FromView
{
    public function __construct($jadwal)
    {
        $this->jadwal = $jadwal;
    }

    public function view(): View
    {
        return view('absendok.xjadwal', [
            'jadwal' => $this->jadwal,
        ]);
    }
}
