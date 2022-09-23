<?php

namespace App\Import;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PartnerTransImport implements ToArray
{
    use Importable;


    public function array(array $row)
    {
        return [
            'transaction_ref' => $row[0],
            'account' => $row[1],
            'amount' => $row[2],
        ];
    }
}
