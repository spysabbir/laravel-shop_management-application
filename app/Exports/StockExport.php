<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockExport implements FromCollection, WithHeadings, WithMapping
{
    protected $productStock;

    public function __construct($productStock)
    {
        $this->productStock = $productStock;
    }

    public function collection()
    {
        return collect($this->productStock);
    }

    public function headings(): array
    {
        return [
            'Category Name',
            'Product Name',
            'Brand Name',
            'Unit Name',
            'Purchase Quantity',
            'Selling Quantity',
            'Stock',
        ];
    }

    public function map($productStock): array
    {
        return [
            $productStock->relationtocategory->category_name,
            $productStock->relationtoproduct->product_name,
            $productStock->relationtobrand->brand_name,
            $productStock->relationtounit->unit_name,
            $productStock->total_purchase_quantity,
            $productStock->total_selling_quantity,
            $productStock->stock_quantity,
        ];
    }
}
