<?php

namespace App\Services;

use App\Repositories\BookRepository;
use App\Services\Contracts\IBookService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BookService implements IBookService
{
    /**
     * @var string
     * Support search in these data sources: database | elasticsearch
     */
    private string $dataSource = 'database';

    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function search(string $keyword, int $limit = 10): Collection|LengthAwarePaginator
    {
        $books = $this->bookRepository->search($keyword, $limit);

        return $books;
    }
}
