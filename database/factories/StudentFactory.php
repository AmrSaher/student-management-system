<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randID = (int)mt_rand(1, 6);

        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'image_path' => $this->faker->imageUrl,
            'grade_id' => $randID,
            'appointment_id' => $randID
        ];
    }
}
