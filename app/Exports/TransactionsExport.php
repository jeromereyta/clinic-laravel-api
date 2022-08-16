<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
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
            'transaction_code',
            'payment_method',
            'procedures',
            'patient',
            'remarks',
            'total_amount',
            'created_at',
        ];
    }
}
