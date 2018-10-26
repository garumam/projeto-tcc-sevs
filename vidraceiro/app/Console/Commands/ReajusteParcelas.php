<?php

namespace App\Console\Commands;

use App\Budget;
use App\Installment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReajusteParcelas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reajuste:parcelas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        /*$budget = Budget::find(1);
        $novo = $budget->replicate();
        return $novo->save();*/

        Installment::readjust();

    }
}
