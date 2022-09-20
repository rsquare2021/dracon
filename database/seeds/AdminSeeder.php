<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("admins")->insert([
            "name" => "牧野 篤人",
            "email" => "info@sangane.com",
            "password" => Hash::make("makimaki"),
        ]);
    }
}
