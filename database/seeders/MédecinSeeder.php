<?php

namespace Database\Seeders;

use App\Models\Médecin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MédecinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Médecin::factory(47)->create();
    }
}
