<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator;
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
          'tg_channel_msg_id' => $this->faker->randomNumber(3),
           'bx_ticket_id' => $this->faker->randomNumber(4),
           'subject' =>$this->faker->title,
           'description' => $this->faker->text(200),
            'client_id' => "16",
        ];
    }
}
