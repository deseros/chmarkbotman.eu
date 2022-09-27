<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory(2)->create([
         "name" => "admin",
         "email" => "vasya1223@gg.eu",
         "password" => bcrypt("12345"),
        ]);
    }
}
