<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExpenseExport implements FromCollection, WithHeadings, WithMapping
{

    protected $expenses;

    public function __construct($expenses)
    {
        $this->expenses = $expenses;
    }

    public function collection()
    {
        return collect($this->expenses);
    }

    public function headings(): array
    {
        return [
            'Id',
            'Expense Branch',
            'Expense Category',
            'Expense Date',
            'Expense Title',
            'Expense Cost',
            'Expense Description',
        ];
    }

    public function map($expenses): array
    {
        return [
            $expenses->id,
            $expenses->branch_name,
            $expenses->expense_category_name,
            $expenses->expense_date,
            $expenses->expense_title,
            $expenses->expense_cost,
            $expenses->expense_description,
        ];
    }

}
