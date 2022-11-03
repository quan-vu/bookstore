<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository extends BaseRepository
{
    public function __construct()
    {
        $model = app()->make(Book::class);
        parent::__construct($model);
    }

    public function search(string $keyword, int $limit = 10)
    {
        $query = $this->model->select('id', 'title', 'summary', 'publisher_id')
            ->with('publisher:id,name')
            ->with('authors:id,name')
            ->where('title', 'LIKE', "%$keyword%");

        // return $query->get();
        return $query->paginate($limit);
    }
}
