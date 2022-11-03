<?php

namespace Database\Seeders\Sample;

use App\Models\Book;
use App\Models\BookAuthor;
use Database\Seeders\BaseSeeder;

class SampleBookSeeder extends BaseSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create sample 1.000.000 unique books
        $totalBook = 1000000;
        for ($i = 0; $i < $totalBook; $i++) {
            $book = Book::factory()->create([
                'title' => $this->generateUniqueColumnValue('books', 'title', 20),
            ]);
            BookAuthor::factory()->create([
                'book_id' => $book->id,
            ]);
        }
    }
}
