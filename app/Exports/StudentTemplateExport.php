<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentTemplateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([]); // Empty collection for template
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'NIS',
            'Alamat',
            'Telepon',
            'Kelas',
        ];
    }
}
