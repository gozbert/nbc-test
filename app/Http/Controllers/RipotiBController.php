<?php

namespace App\Http\Controllers;

use App\Exports\ApiBReportExport;
use App\Models\BTransaction;
use App\Models\PartnerTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RipotiBController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BTransaction::all();

            return $this->getData($data);
        }

        return view('ripoti.index_b');
    }

    protected function getData($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        $today = Carbon::now();

        $b_transactions = BTransaction::whereDate('transaction_time', '2022-02-16')->get();
        $p_transaction = PartnerTransaction::whereDate('created_at', $today)->get()->groupBy('institution');

        dd($b_transactions, $p_transaction);


    }


    public function download()
    {
        return (new ApiBReportExport())->download('report.xlsx');
    }

}
