<?php

namespace App\Imports;

use App\Models\JadwalDokter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class JadwalDokterImport implements ToCollection, WithStartRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            JadwalDokter::updateOrCreate(
                [
                    'kodedokter' => $row['0'],
                    'namadokter' => $row['1'],
                    'poliklinik' => $row['2'],
                    'hari' =>  str_replace(' ', '', $row['3']),
                    'waktu' =>  str_replace(' ', '', $row['4']),
                ],
                [
                    'jam_mulai' => Date::excelToDateTimeObject($row['5']),
                    'jam_selesai' => Date::excelToDateTimeObject($row['6']),
                ]
            );
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
