<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Support\Carbon;
use Illuminate\Bus\Queueable;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Bus\Batchable;

class TransactionsCsvProcess implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $header;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $header)
    {
        $this->data   = $data;
        $this->header = $header;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data as $item) {
            Transaction::create([
                'date' =>  Carbon::createFromFormat('d/m/Y H:i:s', $item[0])->format('Y-m-d H:i:s'),
                'content' =>  $item[1],
                'amount' => $item[2],
                'type' => $item[3]
            ]);
        }
    }

    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
    }
}
