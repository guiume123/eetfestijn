<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventDate = fake()->dateTimeBetween('+2 weeks', '+3 months');
        $title = fake()->randomElement([
            'Spaghettiavond Chiro Sint-Jan',
            'Eetfestijn KFC Heusden-Zolder',
            'Mosselsouper Fanfare De Eendracht',
            'Vol-au-vent avond Oudercomité Sint-Lambertus',
            'Stoofvleesfestijn KVK Hasselt',
            'BBQ-avond Scouts Genk',
        ]);

        return [
            'title' => $title,
            'location' => fake()->randomElement([
                'Parochiezaal Genk',
                'Sporthal Hasselt',
                'Gemeenschapscentrum Bree',
                'Cultureel Centrum Sint-Truiden',
                'Zaal De Kring, Tongeren',
            ]),
            'description' => fake()->paragraph(3),
            'event_date' => $eventDate,
            'registration_deadline' => (clone $eventDate)->modify('-5 days'),
            'slug' => fake()->unique()->slug(),
        ];
    }
}