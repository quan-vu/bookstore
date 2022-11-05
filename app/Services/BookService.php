<?php

namespace App\Services;

use App\Repositories\BookRepository;
use App\Services\Contracts\IBookService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BookService implements IBookService
{
    private BookRepository $bookRepository;
    private ElasticService $elasticService;

    public function __construct(
        BookRepository $bookRepository,
        ElasticService $elasticService
    )
    {
        $this->bookRepository = $bookRepository;
        $this->elasticService = $elasticService;
    }

    public function search(string $keyword, int $limit = 10, int $page = 1, string $searchEngine = null)
    {
        if (!$searchEngine) {
            $books = $this->bookRepository->search($keyword, $limit, $page);
        } else {
            $books = $this->elasticService->searchBook($keyword, $limit, $page);
        }
        return $books;
    }
}
