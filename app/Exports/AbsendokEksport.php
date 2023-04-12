<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AbsendokEksport implements FromView, ShouldAutoSize
{
    public function __construct($cuti, $tanggal, $absen, $absenekse, $absenreg, $jumlahabsen, $jumlahabsenekse, $jumlahabsenreg, $terlambat, $terlambatekse, $terlambatreg, $avg, $avgekse, $avgreg, $dokter)
    {
        $this->absen = $absen;
        $this->cuti = $cuti;
        $this->absenekse = $absenekse;
        $this->absenreg = $absenreg;
        $this->jumlahabsen = $jumlahabsen;
        $this->jumlahabsenekse = $jumlahabsenekse;
        $this->jumlahabsenreg = $jumlahabsenreg;
        $this->terlambat = $terlambat;
        $this->terlambatekse = $terlambatekse;
        $this->terlambatreg = $terlambatreg;
        $this->avg = $avg;
        $this->avgekse = $avgekse;
        $this->avgreg = $avgreg;
        $this->tanggal = $tanggal;
        $this->dokter = $dokter;
    }

    public function view(): View
    {
        return view('absendok.xrekapdok', [
            'tanggal' => $this->tanggal,
            'absen' => $this->absen,
            'absenekse' => $this->absenekse,
            'absenreg' => $this->absenreg,
            'jumlahabsen' => $this->jumlahabsen,
            'jumlahabsenekse' => $this->jumlahabsenekse,
            'jumlahabsenreg' => $this->jumlahabsenreg,
            'terlambat' => $this->terlambat,
            'terlambatekse' => $this->terlambatekse,
            'terlambatreg' => $this->terlambatreg,
            'avg' => $this->avg,
            'avgekse' => $this->avgekse,
            'avgreg' => $this->avgreg,
            'cuti' => $this->cuti,
            'dokter' => $this->dokter,
        ]);
    }
}
