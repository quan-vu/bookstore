<?php

namespace App\Console\Commands\Elastic;

use App\Models\Book;
use App\Repositories\BookRepository;
use App\Services\ElasticService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ElasticIndexBooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:index-books {limit=1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index books to ElasticSearch on background';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ElasticService $elasticService, BookRepository $bookRepository): int
    {
        $limit = $this->argument('limit');
        $books = $bookRepository->getForIndex($limit);
        $countSuccess = 0;
        $countFailed = 0;
        foreach ($books as $book) {
            $result = $elasticService->indexBook($book);
            if ($result) {
                $countSuccess ++;
                $this->info("[ElasticIndexBooks] Book {$book->id} were indexed successfully");
            } else {
                $countFailed ++;
                $this->info("[ElasticIndexBooks] Book {$book->id} failure to index");
            }
        }
        $this->info("[ElasticIndexBooks] Success: $countSuccess, Failed: $countFailed");
        return CommandAlias::SUCCESS;
    }
}
