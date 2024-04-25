<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            ['name' => 'Inglaterra', 'code' => 'GBP'],
            ['name' => 'Japón',      'code' => 'JPY'],
            ['name' => 'India',      'code' => 'INR'],
            ['name' => 'Dinamarca',  'code' => 'DKK']
        ]);
    }
}
