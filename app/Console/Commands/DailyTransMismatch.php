<?php

namespace App\Console\Commands;

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
    }

    public function sendEmail($email, $message)
    {

        Mail::send('Amount Mismatch', function ($message)  {
            $message->from('inhousedevelopment@nbc.co.tz');
            $message->to($message);
            $message->subject($message);
        });
    }
}
