<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
    protected $description = 'Reajuste das parcelas a prazo';

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
        //
    }
}
