<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AbsensinsEksport implements FromView, ShouldAutoSize
{
    public function __construct($ns, $tanggal, $absensi, $namadokter, $alasan)
    {
        $this->ns = $ns;
        $this->tanggal = $tanggal;
        $this->absensi = $absensi;
        $this->namadokter = $namadokter;
        $this->alasan = $alasan;
    }

    public function view(): View
    {
        return view('absendok.xrekapns', [
            'ns' => $this->ns,
            'tanggal' => $this->tanggal,
            'absensi' => $this->absensi,
            'namadokter' => $this->namadokter,
            'alasan' => $this->alasan,
        ]);
    }

}
