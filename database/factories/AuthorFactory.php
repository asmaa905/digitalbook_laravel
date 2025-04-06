<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublishingHouse>
 */
class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'bio' => $this->faker->name, 
            'image' => $this->faker->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,];
    }
}
