<?php

namespace Database\Seeders;

use App\Models\Modérateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModérateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modérateur::factory(1)->create();
    }
}
