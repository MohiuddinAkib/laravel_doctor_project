<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doctor_categories')->insert([
            'name' => 'bone'
        ]);

        DB::table('doctor_categories')->insert([
            'name' => 'heart'
        ]);

        DB::table('doctor_categories')->insert([
            'name' => 'dentist'
        ]);
    }
}