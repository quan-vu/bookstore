<?php

namespace Tests\Feature\Http;

use App\Models\Author;
use App\Models\Publisher;
use App\Services\BookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $expectedBookDetailStruct = [
        'data' => [
            'id',
            'title',
            'summary',
            'publisher',
            'authors'
        ]
    ];

    private array $expectedBookListStruct = [
        'data' => [
            'total',
            'current_page',
            'per_page',
            'last_page',
            'prev_page_url',
            'next_page_url',
            'items' => [
                '*' => [
                    'id',
                    'title',
                    'summary',
                    'publisher',
                    'authors',
                ]
            ]
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->bookService = app(BookService::class);
        Publisher::factory(10)->create();
        Author::factory(10)->create();
    }

    public function test_search_book()
    {
        $keyword = 'a';
        $route = route('api.book.search', [
            'keyword' => $keyword,
            'per_page' => 10,
            'page' => 1,
        ]);
        echo "\tAPI - Book Search - {$route}\n";

        $response = $this->getJson($route);

        $response->assertOk();
        if($response->json('data')) {
            $response->assertJsonStructure($this->expectedBookListStruct);
        }
    }

    public function test_search_book_with_elastic()
    {
        $keyword = 'a';
        $route = route('api.book.search', [
            'keyword' => $keyword,
            'per_page' => 10,
            'page' => 1,
            'engine' => 1,
        ]);
        echo "\tAPI - Book Search with Elastic - {$route}\n";

        $response = $this->getJson($route);

        $response->assertOk();
        if($response->json('data')) {
            $response->assertJsonStructure($this->expectedBookListStruct);
        }
    }
}
