<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookAuthor>
 */
class BookAuthorFactory extends Factory
{
    private int $latestAuthorId;
    private int $firstAuthorId;
    private int $latestBookId;
    private int $firstBookId;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id' => rand($this->getFirstAuthorId(), $this->getLatestAuthorId()),
            'book_id' => rand($this->getFirstBookId(), $this->getLatestBookId()),
        ];
    }

    private function getFirstAuthorId(): int
    {
        if(empty($this->firstAuthor)) {
            $author = Author::first() ?: Author::factory()->create();
            $this->firstAuthorId = $author->id;
        }
        return $this->firstAuthorId;
    }

    private function getLatestAuthorId(): int
    {
        if(empty($this->latestAuthorId)) {
            $author = Author::latest('id')->first() ?: Author::factory()->create();
            $this->latestAuthorId = $author->id;
        }
        return $this->latestAuthorId;
    }


    private function getFirstBookId(): int
    {
        if(empty($this->firstBook)) {
            $this->firstBookId = Book::first()->id;
        }
        return $this->firstBookId;
    }

    private function getLatestBookId(): int
    {
        if(empty($this->latestBookId)) {
            $this->latestBookId = Book::latest('id')->first()->id;
        }
        return $this->latestBookId;
    }
}
