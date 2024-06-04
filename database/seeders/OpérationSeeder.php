<?php

namespace Database\Seeders;

use App\Models\Opération;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpérationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Opération::factory(3)->create();
    }
}
