<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeacherTemplateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([]); // Empty collection
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'NIP',
            'Mapel',
            'Alamat',
            'Telepon',
        ];
    }
}
