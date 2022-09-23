<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PartnerPerSheet implements FromCollection, WithTitle, WithHeadings
{
    use Exportable;

    protected $data;
    protected $category;

    public function __construct($category, $data)
    {
        $this->data = $data;
        $this->category = $category;
    }

    public function prepareRows($rows)
    {
        return collect($rows)->transform(function ($data) {
            if($data->https){
                $data->https = strtoupper("TRUE");
            }else{
                $data->https = strtoupper("FALSE");
            }

            return $data;
        });
    }


    public function collection()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->category;
    }



    public function headings(): array
    {
        return [
            'Transaction Ref',
            'Institution',
            'Account',
            'Amount',
        ];
    }
}
