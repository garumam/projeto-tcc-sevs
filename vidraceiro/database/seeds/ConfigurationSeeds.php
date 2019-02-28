<?php

use Illuminate\Database\Seeder;
use App\Configuration;

class ConfigurationSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::create([]);
    }
}
