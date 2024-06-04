<?php

namespace Database\Seeders;

use App\Models\DRH;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DrhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DRH::factory(5)->create();
    }
}
