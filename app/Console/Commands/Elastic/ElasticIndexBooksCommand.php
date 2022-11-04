<?php

namespace App\Console\Commands\Elastic;

use App\Models\Book;
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
    public function handle(ElasticService $elasticService): int
    {
        $limit = $this->argument('limit');
        $books = Book::limit($limit)->get();
        var_dump($books->count());
        return CommandAlias::SUCCESS;
    }
}
