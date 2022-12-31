<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            User::updateOrCreate(
                [
                    'employee' => $row['0'],
                ],
                [
                    'name' => $row['1'],
                    'department' => $row['2'],
                    'password' => Hash::make($row['3']),
                ]
            );
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}