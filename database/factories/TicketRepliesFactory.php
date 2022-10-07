<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketRepliesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'replies' => $this->faker->paragraph(),
            'username' => $this->faker->userName(),
        ];
    }
}
