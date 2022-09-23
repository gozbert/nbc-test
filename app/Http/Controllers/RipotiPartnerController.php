<?php

namespace App\Http\Controllers;

use App\Exports\ApiPartnerReportExport;

use App\Models\PartnerTransaction;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class RipotiPartnerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PartnerTransaction::all();

            return $this->getData($data);
        }

        return view('ripoti.index_partnership');
    }

    protected function getData($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function sendMismatch(Request $request)
    {
        $url = env('PUBLICAPIS_URL', 'https://httpbin.org/put');

        PartnerTransaction::truncate();
        DB::beginTransaction();
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->get($url);

            if (!$response->ok()) {
                return response([
                    'errors' => [['ThirdParty connection error status code '. $response->status()]],
                ], 423);
            }

            $jsonData = json_decode($response->getBody(), true);
            $count = $jsonData['count'];
            $entries = $jsonData['entries'];

            foreach ($entries as $row) {
                $api_data = array_change_key_case($row, CASE_LOWER);
                PartnerTransaction::create($api_data);
            }

            DB::commit();

        } catch (ConnectionException $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response([
                'errors' => [['Something went wrong']],
            ], 423);
        }

        return response([
            'message' => "Added successfully",
        ], 200);
    }



    public function download()
    {
        return (new ApiPartnerReportExport())->download('report.xlsx');
    }

}
