<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublishingHouse>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->name, // fixed: changed from location to address
            // 'price' => $this->faker->numberBetween(1, 5000),
            'author_id' => $this->faker->numberBetween(1, 10), // fixed: changed from location to address
            'category_id' => $this->faker->numberBetween(1, 10), // fixed: changed from location to address
            'publish_house_id' => $this->faker->numberBetween(1, 10), // fixed: changed from location to address
            'published_by' => $this->faker->numberBetween(1, 10), // fixed: changed from location to address
            'publish_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'image' => $this->faker->imageUrl(),
            'pdf_link' => $this->faker->url(),
            'is_published' => 'accepted',
            'pdf_link' => $this->faker->url(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
            'rating' => $this->faker->numberBetween(1, 5),



        ];
    }
}
