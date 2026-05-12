<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => '+32 4' . fake()->numerify('## ## ## ##'),
            'number_of_people' => fake()->numberBetween(1, 6),
            'notes' => fake()->optional(0.3)->sentence(),
            'paid_at' => fake()->optional(0.6)->dateTimeBetween('-1 week', 'now'),
        ];
    }
}