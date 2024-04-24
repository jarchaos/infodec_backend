<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'country_id' => 1,
                'name' => 'Libra esterlina',
                'symbol' => '£'
            ],
            [
                'country_id' => 2,
                'name' => 'Yen japonés',
                'symbol' => '¥'
            ],
            [
                'country_id' => 3,
                'name' => 'Rupia india',
                'symbol' => '₹'
            ],
            [
                'country_id' => 4,
                'name' => 'Corona danesa',
                'symbol' => 'kr'
            ],
        ]);
    }
}
