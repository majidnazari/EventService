<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{

     protected $model = Event::class;

     
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 1000),
            'event_name' => $this->faker->word,
            'payload_version' => 1,
            'payload' => [
                'key1' => $this->faker->word,
                'key2' => $this->faker->word,
            ],
            'occurred_at' => now(),
        ];
    }
   
}
