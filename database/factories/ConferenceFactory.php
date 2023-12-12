<?php

namespace Database\Factories;

use App\Enums\Region;
use App\Enums\Status;
use App\Models\Conference;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConferenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conference::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->realText(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
            'status' => $this->faker->randomElement(Status::class),
            'region' => $this->faker->randomElement(Region::class),
            'venue_id' => Venue::factory(),
            'is_published' => $this->faker->boolean(20),
        ];
    }
}
