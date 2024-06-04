<?php

namespace Database\Seeders;
use App\Models\Hopital;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HopitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hopital::factory(1)->create();
    }
}
