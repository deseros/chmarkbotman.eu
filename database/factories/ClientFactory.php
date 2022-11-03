<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_client' => $this->faker->userName(),
             'bx_id_group' => $this->faker->randomNumber(3),
             'bx_id_user' => $this->faker->randomNumber(3),
             'channel_chat_id' => $this->faker->randomNumber(3),
             'invait_link_channel' => $this->faker->url(),
             'key_license_telegram' => $this->faker->uuid(),
        ];
    }
}
