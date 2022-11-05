<?php

namespace App\Services\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface IBookService
{
    public function search(string $keyword, int $limit, int $page = 1, string $searchEngine = null);
}
