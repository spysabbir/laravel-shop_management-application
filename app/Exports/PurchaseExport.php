<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PurchaseExport implements FromCollection, WithHeadings, WithMapping
{

    protected $purchase_summaries;

    public function __construct($purchase_summaries)
    {
        $this->purchase_summaries = $purchase_summaries;
    }

    public function collection()
    {
        return collect($this->purchase_summaries);
    }

    public function headings(): array
    {
        return [
            'Id',
            'Invoice No',
            'Supplier Name',
            'Grand Total',
            'Payment Status',
            'Payment Amount',
            'Due Amount',
            'Purchase Date',
        ];
    }

    public function map($purchase_summaries): array
    {
        return [
            $purchase_summaries->id,
            $purchase_summaries->purchase_invoice_no,
            $purchase_summaries->relationtosupplier->supplier_name,
            $purchase_summaries->grand_total,
            $purchase_summaries->payment_status,
            $purchase_summaries->payment_amount,
            $purchase_summaries->grand_total - $purchase_summaries->payment_amount,
            $purchase_summaries->purchase_date,
        ];
    }
}
