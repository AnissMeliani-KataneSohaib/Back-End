<?php

namespace Database\Seeders;

use App\Models\Réceptionniste;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RéceptionnisteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Réceptionniste::factory(1)->create();
    }
}
