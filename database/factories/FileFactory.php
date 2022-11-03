<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bx_id_file' => $this->faker->randomNumber(5),
            'original_name' => $this->faker->firstNameMale(),
            'file_name' => $this->faker->text(10),
            'file_size' => $this->faker->randomNumber(5),
            'file_path' => $this->faker->filePath(),
            'mime' => $this->faker->mimeType(),
            'extension' => $this->faker->fileExtension(),
        ];
    }
}
