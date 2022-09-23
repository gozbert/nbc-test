<?php

namespace App\Http\Controllers\Api\V1;

use App\Import\PartnerTransImport;
use App\Models\PartnerTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Excel;

class TransactionController extends Controller
{

    public function upload(Request $request)
    {
        $institutionName = request()->header('institution-name');

        Log::channel($institutionName)->info("Transaction started");


        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt,xlsx',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if (!in_array($institutionName, ['CompanyX', 'InstitutionY'])) {
            return response([
                "success" => false,
                "message" => "Header information not correct",
            ], 400);
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $file = $request->file('file');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
            $this->checkUploadedFileProperties($extension, $fileSize);
            $location = 'uploads';

            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);

            if ($extension == 'csv') {
                return $this->csvProcess($filepath, $institutionName);
            } elseif ($extension == 'xlsx') {
                return $this->excelProcess($filepath, $institutionName);
            }
        } else {
            //no file was uploaded
            Log::channel($institutionName)->info("No file was uploaded");
            Log::channel($institutionName)->info("Transaction Ended");
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

    private function csvProcess($filepath, $institutionName)
    {
        $file = fopen($filepath, "r");
        $data = array();
        $i = 0;
        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);
            // Skip first row (Remove below comment if you want to skip the first row)
            if ($i == 0) {
                $i++;
                continue;
            }
            for ($c = 0; $c < $num; $c++) {
                $data[$i][] = $filedata[$c];
            }
            $i++;
        }
        fclose($file);
        $j = 0;

        foreach ($data as $importData) {

            $j++;
            try {
                DB::beginTransaction();
                PartnerTransaction::create([
                    'transaction_ref' => $importData[0],
                    'account' => $importData[1],
                    'amount' => $importData[2],
                    'institution' => $institutionName
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::channel($institutionName)->error($e);
            }
        }

        Log::channel($institutionName)->info("$j records successfully uploaded");
        Log::channel($institutionName)->info("Transaction Ended");
        return response()->json([
            'message' => "$j records successfully uploaded"
        ]);
    }


    private function excelProcess($filepath, $institutionName)
    {

        $data = (new PartnerTransImport)->toArray($filepath);


        $j = 0;
        foreach ($data[0] as $key => $importData) {
            if ($key == 0) {
                continue;
            }
            $j++;
            try {
                DB::beginTransaction();
                PartnerTransaction::create([
                    'transaction_ref' => $importData[0],
                    'account' => $importData[1],
                    'amount' => $importData[2],
                    'institution' => $institutionName
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::channel($institutionName)->error($e);
            }
        }

        Log::channel($institutionName)->info("$j records successfully uploaded");
        Log::channel($institutionName)->info("Transaction Ended");
        return response()->json([
            'message' => "$j records successfully uploaded"
        ]);
    }


    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }
}
