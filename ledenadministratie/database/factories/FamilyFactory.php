<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

     // This is used in DatabaseSeeder.php
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'tags' => 'laravel, api, backend',
            'address' => $this->faker->address(),
            'email' => $this->faker->email(),
            'website' => $this->faker->url(),
            'description' =>$this->faker->paragraph(5)
        ];
    }
}
