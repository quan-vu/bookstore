<?php

namespace Tests\Unit\Services;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use App\Services\BookService;
use App\Services\Contracts\IBookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;

    private IBookService $bookService;

    public function setUp(): void
    {
        parent::setUp();
        $this->bookService = app(BookService::class);
        Publisher::factory(10)->create();
        Author::factory(10)->create();
    }

    public function test_search_books()
    {
        Book::factory()->create(['title' => 'hallo 2022']);
        $keyword = 'a';
        $books = $this->bookService->search($keyword);
        $this->assertNotEmpty($books);
    }
}
