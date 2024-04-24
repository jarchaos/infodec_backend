<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            ['country_id' => 1, 'name' => 'Londres'],
            ['country_id' => 1, 'name' => 'Manchester'],
            ['country_id' => 2, 'name' => 'Tokio'],
            ['country_id' => 2, 'name' => 'Osaka'],
            ['country_id' => 3, 'name' => 'Delhi'],
            ['country_id' => 3, 'name' => 'Mumbai'],
            ['country_id' => 4, 'name' => 'Copenhague'],
            ['country_id' => 4, 'name' => 'Aarhus']
        ]);
    }
}
