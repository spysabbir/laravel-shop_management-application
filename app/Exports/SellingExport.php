<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SellingExport implements FromCollection, WithHeadings, WithMapping
{
    protected $selling_summaries;

    public function __construct($selling_summaries)
    {
        $this->selling_summaries = $selling_summaries;
    }

    public function collection()
    {
        return collect($this->selling_summaries);
    }

    public function headings(): array
    {
        return [
            'Id',
            'Invoice No',
            'Customer Name',
            'Grand Total',
            'Payment Status',
            'Payment Amount',
            'Due Amount',
            'Selling Date',
        ];
    }

    public function map($selling_summaries): array
    {
        return [
            $selling_summaries->id,
            $selling_summaries->selling_invoice_no,
            $selling_summaries->relationtocustomer->customer_name,
            $selling_summaries->grand_total,
            $selling_summaries->payment_status,
            $selling_summaries->payment_amount,
            $selling_summaries->grand_total - $selling_summaries->payment_amount,
            $selling_summaries->selling_date,
        ];
    }
}
