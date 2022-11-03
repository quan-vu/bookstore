<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    private int $latestPublisherId;
    private int $firstPublisherId;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->unique()->text(rand(10, 100)),
            'summary' => fake()->text(rand(100, 255)),
            'publisher_id' => rand($this->getFirstPublisherId(), $this->getLatestPublisherId()),
        ];
    }

    private function getFirstPublisherId(): int
    {
        if(empty($this->firstPublisher)) {
            $publisher = Publisher::first() ?: Publisher::factory()->create();
            $this->firstPublisherId = $publisher->id;
        }
        return $this->firstPublisherId;
    }

    private function getLatestPublisherId(): int
    {
        if(empty($this->latestPublisherId)) {
            $publisher = Publisher::latest('id')->first() ?: Publisher::factory()->create();
            $this->latestPublisherId = $publisher->id;
        }
        return $this->latestPublisherId;
    }
}
