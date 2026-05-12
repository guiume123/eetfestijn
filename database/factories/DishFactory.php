<?php

namespace Database\Factories;

use App\Models\Dish;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dish>
 */
class DishFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dishes = [
            ['name' => 'Tomatensoep met balletjes', 'type' => 'voorgerecht', 'price_cents' => 600],
            ['name' => 'Garnaalcocktail', 'type' => 'voorgerecht', 'price_cents' => 950],
            ['name' => 'Stoofvlees met frieten', 'type' => 'hoofdgerecht', 'price_cents' => 1800],
            ['name' => 'Vol-au-vent met kroketten', 'type' => 'hoofdgerecht', 'price_cents' => 1700],
            ['name' => 'Spaghetti bolognese', 'type' => 'hoofdgerecht', 'price_cents' => 1400],
            ['name' => 'Kinderspaghetti', 'type' => 'hoofdgerecht', 'price_cents' => 800],
            ['name' => 'Veggie lasagne', 'type' => 'hoofdgerecht', 'price_cents' => 1500],
            ['name' => 'Dame Blanche', 'type' => 'dessert', 'price_cents' => 600],
            ['name' => 'Tiramisu', 'type' => 'dessert', 'price_cents' => 650],
        ];

        $dish = fake()->randomElement($dishes);

        return [
            'event_id' => Event::factory(),
            'name' => $dish['name'],
            'type' => $dish['type'],
            'price_cents' => $dish['price_cents'],
            'max_quantity' => fake()->randomElement([50, 80, 100, 120, null]),
        ];
    }
}