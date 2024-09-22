<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AbsenpoliEksport implements FromView, ShouldAutoSize
{
    public function __construct($poli, $tanggal, $absensi, $namadokter, $alasan)
    {
        $this->poli = $poli;
        $this->tanggal = $tanggal;
        $this->absensi = $absensi;
        $this->namadokter = $namadokter;
        $this->alasan = $alasan;
    }

    public function view(): View
    {
        return view('absendok.xrekappoli', [
            'poli' => $this->poli,
            'tanggal' => $this->tanggal,
            'absensi' => $this->absensi,
            'namadokter' => $this->namadokter,
            'alasan' => $this->alasan,
        ]);
    }
}
