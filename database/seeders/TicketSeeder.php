<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Client;
use App\Models\File;
use App\Models\Tags;
use App\Models\User;
use App\Models\TicketReplies;
use Illuminate\Support\Facades\Log;
class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::inRandomOrder()->firstOrFail();
        $client = Client::inRandomOrder()->firstOrFail();
        $file = File::inRandomOrder()->firstOrFail();
        $tickets = Ticket::factory()->count(5)->create(['assigned_to' => $user->id, 'client_id' => $client->id]);
        $openTag = Tags::inRandomOrder()->firstOrFail();

       foreach ($tickets as $ticket) {
          $ticket->tags()->attach($openTag->id);
          Ticket::find($ticket->id)->files()->attach($file->id);
          $reply = TicketReplies::factory()->count(3)->create(['ticket_id' => $ticket->id, 'user_id' => $user->id]);
          foreach($reply as $reply_item){
            TicketReplies::find($reply_item->id)->files()->attach($file->id);
          }
        }
    }
}
