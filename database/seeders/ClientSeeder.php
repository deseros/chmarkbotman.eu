<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = Client::factory()->count(10)->create();
        $user = User::inRandomOrder()->limit(3)->get();

        foreach($client as $client_item){

            foreach($user as $user_one)
            {
             $client_item->users()->attach($user_one->id);
            }

       }
    }
}
