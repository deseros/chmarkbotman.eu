<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Client;
use App\Models\Tags;
use App\Models\User;
use App\Models\TicketReplies;
use Illuminate\Support\Facades\Log;
class TicketSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::inRandomOrder()->firstOrFail();;
        $client = Client::inRandomOrder()->firstOrFail();;

        $tickets = Ticket::factory()->count(100)->create(['assigned_to' => $user->id, 'client_id' => $client->id]);
        $openTag = Tags::inRandomOrder()->firstOrFail();

       foreach ($tickets as $ticket) {
          $ticket->tags()->attach($openTag->id);
          TicketReplies::factory()->count(10)->create(['ticket_id' => $ticket->id]);

        }
    }
}
