<?php

namespace App\Exports;

use App\Models\PartnerTransaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ApiPartnerReportExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {

        $sheets = [];
        $data = PartnerTransaction::select(
            'transaction_ref',
            'account',
            'amount',
            'institution',
        )->get()->groupBy('institution');

        foreach($data as $key => $row){
            $sheets[] = new PartnerPerSheet($key, $row);
        }

        return $sheets;
    }
}
