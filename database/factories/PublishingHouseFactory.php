<?php

namespace Database\Factories;

use App\Models\PublishingHouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublishingHouse>
 */
class PublishingHouseFactory extends Factory
{
    protected $model = PublishingHouse::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'location' => $this->faker->address, // fixed: changed from location to address
            'email' => $this->faker->unique()->safeEmail,
            'website' => $this->faker->url, // fixed: changed from website to url
        ];
    }
}
