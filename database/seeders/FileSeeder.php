<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::inRandomOrder()->first();
        $ticket = Ticket::inRandomOrder()->first();
        $file = File::factory()->count(15)->create(['user_id' => $user->id]);

        //foreach($file as $file_item){
          //  $file_item->attach_ticket()->attach($ticket->id);
       // }
    }
}
