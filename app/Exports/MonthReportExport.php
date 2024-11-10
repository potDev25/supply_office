<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class MonthReportExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $stocks;
    public function __construct($stocks){
        $this->stocks = $stocks;
    }

    public function collection()
    {
        return $this->stocks;
    }

    public function headings(): array
    {
        return [
            'Department Name',
            'RIS Number',
            'Supply Name',
            'Description',
            'Category Name',
            'Unit', 
            'Qnty',
            'Total Price',
            'Total Costs',
            'Date',
        ];
    }
}
