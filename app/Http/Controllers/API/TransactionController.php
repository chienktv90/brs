<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Transaction;
use Validator;
use App\Http\Resources\Transaction as TransactionResource;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use App\Jobs\TransactionsCsvProcess;
use Illuminate\Support\Facades\Bus;
   
class TransactionController extends BaseController
{

    /*
    public function upload()
    {
        if (request()->has('mycsv')) {
                $data = array_map('str_getcsv', file(request()->mycsv));
                //return $data[1];
                //$header = $data[0];
                unset($data[0]);//remove row header
                foreach ($data as $value) {
                    Transaction::create([
                        'date' =>  Carbon::createFromFormat('d/m/Y H:i:s', $value[0])->format('Y-m-d H:i:s'),
                        'content' =>  $value[1],
                        'amount' => $value[2],
                        'type' => $value[3]
                    ]);
                }
                return $this->sendResponse([], 'Transaction read file successfully.');
            }
        return $this->sendResponse([], 'Error!.');
    }
    */

    public function upload()
    {
        if (request()->has('mycsv')) {
            $data   =   file(request()->mycsv);
            // Chunking file
            $chunks = array_chunk($data, 1000);

            $header = [];
            $batch  = Bus::batch([])->dispatch();

            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);

                if ($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }

                $batch->add(new TransactionsCsvProcess($data, $header));
            }

            return $batch;
        }

        return $this->sendResponse([], 'please upload file csv');
    }

    public function batch()
    {
        $batchId = request('id');
        return Bus::findBatch($batchId);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction = Transaction::latest();
        return $this->sendResponse(TransactionResource::collection($transaction->take(5)->get()), 'Total records: '. $transaction->count());
    }

}