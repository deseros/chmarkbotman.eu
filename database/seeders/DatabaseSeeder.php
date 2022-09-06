<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        AdminUser::factory(1)->create([
         "name" => "admin",
         "email" => "vasya1223@gg.eu",
         "password" => bcrypt("12345"),
        ]);
    }
}
