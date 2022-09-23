<?php

namespace App\Exports;

use App\Models\BTransaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApiBReportExport implements FromCollection
{
    use Exportable;

    public function collection()
    {
        return BTransaction::all();
    }


}
