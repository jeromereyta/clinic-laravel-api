<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientsExport implements FromCollection, WithHeadings
{
    protected array $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection(): Collection
    {
        return collect($this->data);
    }

    public function headings() :array
    {
        return [
            'active',
            'age',
            'birth_date',
            'barangay',
            'civil_status',
            'city',
            'email',
            'gender',
            'name',
            'first_name',
            'middle_name',
            'last_name',
            'phone_number',
            'mobile_number',
            'profile_picture',
            'province',
            'street_address',
            'created_at',
            'updated_at',
        ];
    }
}
