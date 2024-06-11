<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('points')->insert([
            ['name' => 'A', 'latitude' => 51.505, 'longitude' => -0.09],
            ['name' => 'B', 'latitude' => 51.515, 'longitude' => -0.10],
            ['name' => 'C', 'latitude' => 51.520, 'longitude' => -0.12],
            ['name' => 'D', 'latitude' => 51.525, 'longitude' => -0.08],
            // Add more points as needed
        ]);
    }
}
