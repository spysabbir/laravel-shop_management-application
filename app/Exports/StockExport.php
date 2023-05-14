<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockExport implements FromCollection, WithHeadings, WithMapping
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return collect($this->products);
    }

    public function headings(): array
    {
        return [
            'Id',
            'Category Name',
            'Product Name',
            'Brand Name',
            'Unit Name',
            'Purchase Quantity',
            'Selling Quantity',
            'Stock',
        ];
    }

    public function map($products): array
    {
        return [
            $products->id,
            $products->relationtocategory->category_name,
            $products->product_name,
            $products->relationtobrand->brand_name,
            $products->relationtounit->unit_name,
            $products->purchase_quantity,
            $products->selling_quantity,
            $products->purchase_quantity - $products->selling_quantity,
        ];
    }
}
