<?php

namespace App\Console\Commands\Elastic;

use App\Services\ElasticService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ElasticInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get information of ElasticSearch';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ElasticService $elasticService): int
    {
        $this->info("ElasticSearch Info:");
        print_r($elasticService->getInfo());
        return CommandAlias::SUCCESS;
    }
}
