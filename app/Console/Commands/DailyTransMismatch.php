<?php

namespace App\Console\Commands;

use App\Models\BTransaction;
use App\Models\PartnerTransaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DailyTransMismatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:trans-mismatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily transaction mismatch checker';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now();

        $b_transactions = BTransaction::whereDate('transaction_time', '2022-02-16')->get();
        $p_transaction = PartnerTransaction::whereDate('created_at', $today)->get()->groupBy('institution');

        foreach ($p_transaction as $key => $trans) {

            $transactions = collect($trans);
            $transaction_refs = $transactions->pluck('transaction_ref');

            $b_transactions_not_exists = $b_transactions->whereNotIn('transaction_ref', $transaction_refs);

            $total_mismatch = $b_transactions->sum('amount');

            $message = 'Bank B and ' . $key . ', Mismatch Amount for ' . $today->diffForHumans() . ' is ' . $total_mismatch;


            if ($key == 'InstitutionY') {
                $response = [
                    'messaget' => $message,
                    'mismatchAmount' => $total_mismatch,
                    "transactions" => $b_transactions_not_exists->toArray(),
                ];
            } else {
                $this->sendEmail('', $message);
            }
        }
    }

    public function sendEmail($email, $message)
    {

        Mail::send('Amount Mismatch', function ($message) {
            $message->from('inhousedevelopment@nbc.co.tz');
            $message->to($message);
            $message->subject($message);
        });
    }
}
