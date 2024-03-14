<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $now = now();

        return [
            'name' => 'TTSDB-' . $this->faker->unique()->bothify('sd4o??#'),
            'type' => $this->faker->randomElement(['class', 'group']),
            'date_start' => $now->subDays(100),
            'date_end' => $now->addDays(100),
        ];
    }
}
