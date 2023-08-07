<?php

namespace App\Console\Commands;

use App\Models\Insurance;
use Illuminate\Console\Command;

class HelloWorldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:world';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Insurance::create([
            'customer_id' => 3,
            'insurance_company' => 'ABC',
            'date_of_insurance' => '2022-07-22',
            'insurance_amount' => 100,
            'date_of_expiry_of_insurance' => 3,
        ]);
        return 0;
    }
}
