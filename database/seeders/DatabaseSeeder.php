<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Event::factory(4)->create()->each(function ($event) {
            $dishes = Dish::factory(fake()->numberBetween(5, 7))
                ->create(['event_id' => $event->id]);

            $reservations = Reservation::factory(fake()->numberBetween(10, 15))
                ->create(['event_id' => $event->id]);

            $reservations->each(function ($reservation) use ($dishes) {
                $chosenDishes = $dishes->random(fake()->numberBetween(1, 3));
                foreach ($chosenDishes as $dish) {
                    $reservation->dishes()->attach($dish->id, [
                        'quantity' => fake()->numberBetween(1, $reservation->number_of_people),
                    ]);
                }
            });
        });
    }
}