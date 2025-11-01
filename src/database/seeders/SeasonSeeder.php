<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Season;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run():void
    {
        $seasons = ['春', '夏', '秋', '冬'];

        foreach ($seasons as $name) {
            Season::create(['name' => $name]);
        }

    }
}
