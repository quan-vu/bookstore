<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\BooksResource;
use App\Services\Contracts\IBookService;
use Illuminate\Http\Request;

class BookController extends BaseAPIController
{
    private IBookService $bookService;

    public function __construct(IBookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function search(Request $request)
    {
        try {
            $input = $request->validate([
                    'keyword' => 'required|string',
                    'per_page' => 'nullable|numeric',
                    'page' => 'nullable|numeric',
                ], $request->only(['keyword', 'per_page', 'page'])
            );
            $books = $this->bookService->search($input['keyword'], $input['per_page'] ?? 10, $input['page'] ?? 1, $request->input('engine'));
            return $this->success($books, "Search books successfully.", 200, 'BooksResource');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

}
